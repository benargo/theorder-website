<?php

namespace App\Http\Controllers\GuildBank;

use App\Blizzard\Warcraft\Items as ItemsRepository;
use App\Guild\Bank\Stock;
use App\Guild\Bank\Banker;
use App\Http\Controllers\Controller;
use App\Rules\StockSchemaRule;
use ArrayAccess;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use JsonSchema\Validator;

class UpdateStockController extends Controller
{
    protected $items;
    protected $user;

    public function __construct(ItemsRepository $items)
    {
        $this->items = $items;
    }

    public function postUpdateStock(Request $request)
    {
        // Get the user from the request...
        $this->user = $request->user();

        // Validate the imported stock...
        $validated_data = $request->validate([
            'stock' => [
                'required',
                'json',
                new StockSchemaRule(new Validator)
            ]
        ]);

        // Decode the imported stock...
        $stock = (array) json_decode(Arr::get($validated_data, 'stock'));
        $stock = collect(Arr::get($stock, 'stock'));
        $stock = $this->mapStock($stock);

        // Respond...
        return $this->respond($stock);
    }

    protected function mapStock(ArrayAccess $stock)
    {
        try {
            // Loop over each of the bags...
            $models = $stock->flatMap(function ($entries, $key) {
                // Get the singular form of the key. This will either be mail or
                // bag...
                $key = Str::singular($key);

                // Wrap the entries in a collection, so we can use the
                // mapWithKeys function.
                $entries = collect($entries);

                if (count($entries) > 0) {
                    return $entries->map(function ($entry) use ($key) {
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
                                    'updated_by_user_id' => $this->user->id,
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
                            // return false to remove this entry from the
                            // returned collection...
                            return false;
                        }
                    })->filter();
                }
            });

            return $models;
        }
        catch (ModelNotFoundException $e) {
            if ($e->getModel() == 'App\Guild\Bank\Banker') {
                abort(400, 'One of the characters you specified is not authorised to act as a banker.');
            }
            elseif ($e->getModel() == 'App\Guild\Bank\Stock') {
                abort(400, 'One of the stock entries specified could not be found in the database.');
            }
        }
    }

    protected function respond(ArrayAccess $entries)
    {
        return response()->json([
            'status'  => 'Accepted',
            'user' => [
                'id'        => $this->user->id,
                'battletag' => $this->user->battletag,
            ],
            'entries' => $entries->values(),
        ]);
    }
}
