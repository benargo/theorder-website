<?php

namespace App\Http\Controllers\GuildBank;

use GuzzleHttp\Psr7;
use App\Guild\Bank\Stock;
use JsonSchema\Validator;
use Illuminate\Http\Request;
use App\Rules\StockSchemaRule;
use App\Blizzard\Warcraft\Items;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use GuzzleHttp\Exception\ClientException;

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

        return response()->json($stock);
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
            $stock = json_decode($validated_data['stock']);
            $stock = collect($stock->entries);

            // Loop over each of the stock entries...
            $models = $stock->mapWithKeys(function ($entry) use ($user) {
                // Validate the item...
                $item = $this->items->getItem($entry->item->id);

                $model = Stock::updateOrCreate(
                    // Where...
                    [
                        'banker_name' => $entry->banker_name,
                        'bag_number'  => $entry->bag_number,
                        'slot_number' => $entry->slot_number,
                    ],

                    // Update/Create...
                    [
                        'banker_name'        => $entry->banker_name,
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
