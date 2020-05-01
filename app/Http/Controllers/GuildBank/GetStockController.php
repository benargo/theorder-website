<?php

namespace App\Http\Controllers\GuildBank;

use App\Repositories\Interfaces\ItemRepositoryInterface;
use App\Guild\Bank\Banker;
use App\Guild\Bank\Stock;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class GetStockController extends Controller
{
    protected $items;

    public function __construct(ItemRepositoryInterface $items)
    {
        $this->items = $items->withMedia();
    }

    public function getStock()
    {
        $stock = Stock::all();

        $stock = $stock->map([$this, 'mapStockCollection']);

        return response()->json(['stock' => $stock])
                         ->header('Date', $this->getLastModifiedDate());
    }

    public function mapStockCollection($value, $key)
    {
        // Load the banker from the database...
        $value->banker = Banker::find($value->banker_id);
        unset($value->banker_id);

        // Load the item from the repository...
        $value->item = $this->items->find($value->item_id);
        unset($value->item_id);

        // Remove any 'Binds when picked up' items...
        if (property_exists($value->item, 'itemBind') && $value->item->itemBind == 1) {
            return false;
        }

        return $value;
    }

    protected function getLastModifiedDate()
    {
        $last_modified = DB::table('guild_bank_stock')
                            ->select('updated_at')
                            ->latest()
                            ->first();

        if ($last_modified) {
            $last_modified = $last_modified->updated_at;
        }

        return $last_modified ?: now();
    }
}
