<?php

namespace App\Blizzard\Warcraft\Facades;

use App\Blizzard\Warcraft\Classes as Accessor;
use Illuminate\Support\Facades\Facade;

class Classes extends Facade
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
