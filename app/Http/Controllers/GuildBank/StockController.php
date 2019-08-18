<?php

namespace App\Http\Controllers\GuildBank;

use GuzzleHttp\Psr7;
use App\Guild\Bank\Stock;
use JsonSchema\Validator;
use App\Guild\Bank\Banker;
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
            $decoded = json_decode($validated_data['stock']);
            $stock = collect($decoded->stock);

            // Loop over each of the stock entries...
            $models = $stock->mapWithKeys(function ($entry) use ($user) {
                // Validate the item...
                $item = $this->items->getItem($entry->item->id);

                // Validate the banker...
                $banker = Banker::where('name', $entry->banker_name)->firstOrFail();

                $model = Stock::updateOrCreate(
                    // Where...
                    [
                        'banker_id'   => $banker->id,
                        'bag_number'  => $entry->bag_number,
                        'slot_number' => $entry->slot_number,
                    ],

                    // Update/Create...
                    [
                        'banker_id'          => $banker->id,
                        'is_in_bags'         => $entry->is_in_bags,
                        'bag_number'         => $entry->bag_number,
                        'slot_number'        => $entry->slot_number,
                        'item_id'            => $item->id,
                        'count'              => $entry->count,
                        'updated_by_user_id' => $user->id,
                    ]
                );

                return [$model->id => $model];
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
            abort(403, 'One of the characters you specified is not authorised to act as a banker.');
        }
        catch (ClientException $e) {
            return response()->json([
                'exception'    => 'GuzzleHttp\Exception\ClientException',
                'request'  => Psr7\str($e->getRequest()),
                'response' => Psr7\str($e->getResponse()),
            ]);
        }
        catch (\Exception $e) {
            return response()->json(['e' => $e]);
        }
    }
}
