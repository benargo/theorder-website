<?php

namespace App\Repositories;

use App\Blizzard\Warcraft\Item;
use App\Blizzard\Warcraft\Service as WarcraftService;
use App\Repositories\Interfaces\ItemRepositoryInterface;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Support\Facades\Cache;

class ItemRepository implements ItemRepositoryInterface
{
    protected $service;

    protected $items = [];

    protected $with_media = false;

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

    public function withMedia($with_media = true)
    {
        $this->with_media = $with_media;

        return $this;
    }

    protected function fetch($id, array $options = []): Item
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
        catch (RequestException $e) {
            return null;
        }

        $item = new Item($item_attributes);

        if ($this->with_media) {
            $item->getMediaAssets($this->service);
        }

        return $item;
    }
}
