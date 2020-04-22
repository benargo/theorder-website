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
use App\Blizzard\Warcraft\Items as ItemsRepository;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use GuzzleHttp\Exception\ClientException;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class StockController extends Controller
{
    protected $items;

    public function __construct(ItemsRepository $items)
    {
        $this->items = $items;
    }

    public function getStock()
    {
        $stock = Stock::all();

        $stock = $stock->map(function ($row, $key) {
            $row->banker = Banker::find($row->banker_id);
            unset($row->banker_id);

            $row->item = $this->items->getItem($row->item_id);
            unset($row->item_id);

            if (property_exists($row->item, 'itemBind') && $row->item->itemBind == 1) {
                return false;
            }

            return $row;
        });

        $last_modified = DB::table('guild_bank_stock')
                            ->select('updated_at')
                            ->latest()
                            ->first();

        if ($last_modified) {
            $last_modified = $last_modified->updated_at;
        }

        return response()->json(['stock' => $stock])
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
                'json',
                new StockSchemaRule(new Validator)
            ]
        ]);

        // Decode the imported stock...
        try {
            $stock = (array)json_decode(Arr::get($validated_data, 'stock'));
            $stock = collect(Arr::get($stock, 'stock'));

            // Loop over each of the bags...
            $models = $stock->flatMap(function ($entries, $key) use ($user) {
                // Get the singular form of the key. This will either be mail or
                // bag...
                $key = Str::singular($key);

                // Wrap the entries in a collection, so we can use the
                // mapWithKeys function.
                $entries = collect($entries);

                if ($entries->count() > 0) {
                    return $entries->map(function ($entry) use ($key, $user) {
                        // Convert the entry to an array...
                        $entry = (array) $entry;

                        // Validate the banker...
                        $banker = Banker::where('name', Arr::get($entry, 'banker_name'))->first();

                        $item = (array) $this->items->getItem(Arr::get($entry, 'id'));

                        // If there is an item id...
                        if ($item) {
                            // Validate the item...
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

                            // Return the created/updated model.
                            return $model;
                        }
                        // If there isn't an item id, then the item has been
                        // removed.
                        // If an entry doesn't exist in the database, then the
                        // process should continue, and this entry should be
                        // removed from the returned collection...
                        else {
                            $model = Stock::where([
                                'banker_id' => $banker->id,
                                $key        => Arr::get($entry, $key),
                                'slot'      => Arr::get($entry, 'slot'),
                            ])->first();

                            if ($model) {
                                $model->delete();
                            }

                            // If the model was never created or updated, then
                            // return null to remove this entry from the
                            // returned collection...
                            return false;
                        }
                    })->filter();
                }
            });

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
        // catch (\Exception $e) {
        //     return response()->json(['exception' => $e->getMessage()], 500);
        // }
    }
}
