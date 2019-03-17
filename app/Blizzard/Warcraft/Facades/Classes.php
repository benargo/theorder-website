<?php

namespace App\Blizzard\Warcraft\Facades;

use Blizzard\Warcraft\Classes as Accessor;
use Illuminate\Support\Facades\Facade;

class Classes extends Facades
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
