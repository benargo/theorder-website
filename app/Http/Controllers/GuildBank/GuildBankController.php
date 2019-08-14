<?php

namespace App\Http\Controllers\GuildBank;

use Illuminate\Http\Request;
use App\Blizzard\Warcraft\Items;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class GuildBankController extends Controller
{
    protected $items;

    public function __construct(Items $items)
    {
        $this->items = $items;
    }

    public function index()
    {
        $stock = DB::table('guild_bank_stock')
            ->whereNull('withdrawn_at')
            ->get();
    }
}
