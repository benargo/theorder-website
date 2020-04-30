<?php

namespace App\Blizzard\Warcraft;

use Jenssegers\Model\Model;

class Item extends Model
{
    protected $casts = [
        '_links' => 'object',
        '_links.self' => 'object',
        'id' => 'integer',
        'quality' => 'object',
        'level' => 'integer',
        'required_level' => 'integer',
        'media' => 'object',
        'media.key' => 'object',
        'item_class' => 'object',
        'item_class.key' => 'object',
        'item_subclass' => 'object',
        'item_subclass.key' => 'object',
        'inventory_type' => 'object',
        'purchase_price' => 'integer',
        'sell_price' => 'integer',
        'max_count' => 'integer',
        'is_equippable' => 'boolean',
        'is_stackable' => 'boolean',
    ];

    protected $fillable = [
        '_links',
        'id',
        'name',
        'quality',
        'level',
        'required_level',
        'media',
        'item_class',
        'item_subclass',
        'inventory_type',
        'purchase_price',
        'sell_price',
        'max_count',
        'is_equippable',
        'is_stackable',
    ];
}
