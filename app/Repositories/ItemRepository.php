<?php

namespace App\Repositories;

use App\Blizzard\Warcraft\Item;
use App\Blizzard\Warcraft\Service as WarcraftService;
use App\Repositories\Interfaces\ItemRepositoryInterface;
use Illuminate\Support\Facades\Cache;

class ItemRepository implements ItemRepositoryInterface
{
    private $service;

    protected $items = [];

    /**
     * Construct the repository.
     */
    public function __construct(WarcraftService $service)
    {
        $this->service = $service;
    }

    public function all()
    {
        return $this->items;
    }

    public function find($id, array $options = [])
    {
        // First check the list of items already loaded...
        if (array_key_exists($id, $this->items)) {
            return $this->items[$id];
        }

        // First check the cache for the item...
        if (Cache::tags(['blizzard', 'items'])->has($id)) {
            $this->items[$id] = Cache::tags(['blizzard', 'items'])->get($id);
        }

        else {
            // Fetch the item from the API...
            $item = $this->fetch($id, $options);

            // Add the item to the list of items already loaded...
            $this->items[$id] = $item;

            // Store the characters in the cache for a day...
            Cache::tags(['blizzard', 'items'])->put(
                $id,
                $item,
                now()->addDays(30)
            );
        }

        return $this->items[$id];
    }

    private function fetch($id, array $options = []): Item
    {
        try {
            // Fetch the item from the API...
            $item_attributes = (array) json_decode(
                $this->service
                     ->getItem($id, $options)
                     ->getBody()
                     ->getContents()
            );
        }
        catch (ClientException $e) {
            return null;
        }

        return new Item($item_attributes);
    }
}
