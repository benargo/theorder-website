<?php

namespace App\Http\Controllers\GuildBank;

use Carbon\Carbon;
use GuzzleHttp\Psr7;
use App\Guild\Bank\Stock;
use JsonSchema\Validator;
use App\Guild\Bank\Banker;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Rules\StockSchemaRule;
use App\Blizzard\Warcraft\Items;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use GuzzleHttp\Exception\ClientException;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class StockController extends Controller
{
    protected $items;

    public function __construct(Items $items)
    {
        $this->items = $items;
    }

    public function getStock()
    {
        $stock = DB::table('guild_bank_stock')
                    ->whereNull('withdrawn_at')
                    ->get();

        $stock = $stock->map(function ($item, $key) {
            $item->item = $this->items->getItem($item->item_id);
            unset($item->item_id);

            return $item;
        })
        ->filter(function ($item, $key) {
            return $item->item->itemBind <> 1;
        })
        ->groupBy(['banker_name', 'bag_number'])
        ->sortBy('slot_number');

        $last_modified = DB::table('guild_bank_stock')
                            ->select('updated_at')
                            ->latest()
                            ->first();

        if ($last_modified) {
            $last_modified = $last_modified->updated_at;
        }

        return response()->json($stock)
                         ->header('Date', $last_modified);
    }

    public function updateStock(Request $request)
    {
        // Get the user from the request...
        $user = $request->user();

        // Validate the imported stock...
        $validated_data = $request->validate([
            'stock' => [
                'required',
                new StockSchemaRule(new Validator)
            ]
        ]);

        // Decode the imported stock...
        try {
            $stock = collect(Arr::get($validated_data, 'stock.stock'));

            // Loop over each of the bags...
            $models = $stock->map(function ($entries, $key) use ($user) {
                // Get the singular form of the key. This will either be mail or
                // bag...
                $key = Str::singular($key);

                // Wrap the entries in a collection, so we can use the
                // mapWithKeys function.
                $entries = collect($entries);

                return $entries->mapWithkeys(function ($entry) use ($key, $user) {
                    // Validate the banker...
                    $banker = Banker::where('name', Arr::get($entry, 'banker_name'))->firstOrFail();

                    // If there is an item id...
                    if (Arr::get($entry, 'id')) {
                        // Validate the item...
                        $item = $this->items->getItem(Arr::get($entry, 'id'));

                        $model = Stock::updateOrCreate(
                            // Where...
                            [
                                'banker_id' => $banker->id,
                                $key        => Arr::get($entry, $key), // $key is either mail or bag...
                                'slot'      => Arr::get($entry, 'slot'),
                            ],

                            // Update/Create...
                            [
                                'banker_id'          => $banker->id,
                                $key                 => Arr::get($entry, $key), // $key is either mail or bag...
                                'slot'               => Arr::get($entry, 'slot'),
                                'item_id'            => Arr::get($item, 'id'),
                                'count'              => Arr::get($entry, 'count'),
                                'updated_by_user_id' => $user->id,
                            ]
                        );
                    }
                    // If there isn't an item id, then the item has been removed
                    // and the withdrawn_at timestamp needs to be added.
                    // If an entry doesn't exist in the database, then the
                    // process should continue, and this entry should be removed
                    // from the returned collection...
                    else {
                        $model = Stock::firstWhere([
                            'banker_id' => $banker->id,
                            $key        => Arr::get($entry, $key),
                            'slot'      => Arr::get($entry, 'slot'),
                        ]);

                        if ($model) {
                            $model->withdrawn_at = Carbon::now();
                            $model->save();
                        }
                    }

                    // Return the created/updated model. If the model was never
                    // created or updated, then return null to remove this entry
                    // from the returned collection...
                    return $model ? [$model->id => $model] : null;
                });
            })->flatten();

            // Build the response...
            $response = collect([
                'status'  => 'Accepted',
                'user' => [
                    'id'        => $user->id,
                    'battletag' => $user->battletag,
                ],
                'entries' => $models->values()
            ]);

            return response()->json($response);

        }
        catch (ModelNotFoundException $e) {
            if ($e->getModel() == 'App\Guild\Bank\Banker') {
                abort(400, 'One of the characters you specified is not authorised to act as a banker.');
            }
            elseif ($e->getModel() == 'App\Guild\Bank\Stock') {
                abort(400, 'One of the stock entries specified could not be found in the database.');
            }
        }
        catch (ClientException $e) {
            return response()->json([
                'exception'    => 'GuzzleHttp\Exception\ClientException',
                'request'  => Psr7\str($e->getRequest()),
                'response' => Psr7\str($e->getResponse()),
            ], 500);
        }
        catch (\Exception $e) {
            return abort(500, $e->getMessage());
        }
    }
}
