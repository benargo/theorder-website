<?php

namespace App\Blizzard\Warcraft;

use App\Blizzard\Warcraft\Service as WarcraftService;
use Illuminate\Support\Facades\Cache;

class Items
{
    private $service;

    protected $items = [];

    /**
     * Construct the repository.
     */
    public function __construct(WarcraftService $client)
    {
        $this->service = $client;
    }

    /**
     * Get a specific item.
     *
     * @throws GuzzleHttp\Exception\ClientException
     */
    public function getItem($item_id, array $options = [])
    {
        // First check the list of items already loaded...
        if (array_key_exists($item_id, $this->items)) {
            return $this->items[$item_id];
        }

        // First check the cache for the item...
        if (Cache::tags(['blizzard', 'items'])->has($item_id)) {
            $this->items[$item_id] = Cache::tags(['blizzard', 'items'])->get($item_id);
        }

        else {
            // Fetch the item from the API...
            $item = json_decode(
                $this->service
                        ->getItem($item_id, $options)
                        ->getBody()
                        ->getContents()
            );

            // Add the item to the list of items already loaded...
            $this->items[$item_id] = $item;

            // Store the characters in the cache for a day...
            Cache::tags(['blizzard', 'items'])->put(
                $item_id,
                $item,
                now()->addHours(24)
            );
        }

        return $this->items[$item_id];
    }

    public function getItems()
    {
        return collect($this->items);
    }

    public function getAuctionPriceForItem($item)
    {
        return $this->getAuctionPriceForItems([$item]);
    }

    // @TODO
    public function getAuctionPriceForItems(array $items)
    {

    }
}
