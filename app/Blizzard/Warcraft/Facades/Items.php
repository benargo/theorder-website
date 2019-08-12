<?php

namespace App\Blizzard\Warcraft\Facades;

use Blizzard\Warcraft\Items as Accessor;
use Illuminate\Support\Facades\Facade;

class Items extends Facades
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return Accessor::class;
    }

}