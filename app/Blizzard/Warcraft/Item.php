<?php

namespace App\Blizzard\Warcraft;

use App\Blizzard\Warcraft\Service as WarcraftService;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Support\Arr;
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

    public function getMediaAssets(WarcraftService $service, array $options = [])
    {
        $media = $this->getAttribute('media');

        try {
            // Fetch the item from the API...
            $media_attributes = (array) json_decode(
                $service
                    ->getItemMedia($media->id, $options)
                    ->getBody()
                    ->getContents()
            );
        }
        catch (RequestException $e) {
            return;
        }

        $media->assets = Arr::get($media_attributes, 'assets', []);

        $this->setAttribute('media', $media);

        return $media->assets;
    }
}
