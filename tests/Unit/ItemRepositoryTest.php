<?php

namespace Tests\Unit;

use App\Blizzard\Warcraft\Item;
use App\Repositories\Interfaces\ItemRepositoryInterface;
use App\Repositories\ItemRepository;
use Illuminate\Support\Facades\Cache;
use Tests\TestCase;

class ItemRepositoryTest extends TestCase
{
    public function testInstantiation()
    {
        $repository = $this->app->make(ItemRepositoryInterface::class);

        $this->assertInstanceOf(ItemRepositoryInterface::class, $repository);
        $this->assertClassHasAttribute('service', ItemRepository::class);
        $this->assertClassHasAttribute('items', ItemRepository::class);
    }

    public function testAllFunction()
    {
        $repository = $this->app->make(ItemRepositoryInterface::class);

        $this->assertIsArray($repository->all());
        $this->assertEmpty($repository->all());
    }

    public function testFindFunction()
    {
        Cache::shouldReceive('tags')
             ->zeroOrMoreTimes()
             ->with(['blizzard', 'items'])
             ->andReturnSelf();

        Cache::shouldReceive('has')
             ->once()
             ->with(24358)
             ->andReturn(true);

        Cache::shouldReceive('get')
             ->once()
             ->with(24358)
             ->andReturn(new Item(['id' => 24358]));

        $repository = $this->app->make(ItemRepositoryInterface::class);

        $item = $repository->find(24358);

        $this->assertInstanceOf(Item::class, $item);
        $this->assertNotNull($item->getAttribute('id'));
        $this->assertIsInt($item->id);
        $this->assertEquals(24358, $item->id);
    }

    public function testFindFunction2()
    {
        Cache::shouldReceive('tags')
             ->zeroOrMoreTimes()
             ->with(['blizzard', 'items'])
             ->andReturnSelf();

        Cache::shouldReceive('has')
             ->once()
             ->with(24358)
             ->andReturn(false);

        Cache::shouldReceive('put')
             ->once()
             ->with(24358, \Mockery::type(Item::class), \Mockery::type(\DateTimeInterface::class))
             ->andReturnNull();

        $this->mock('App\Blizzard\Warcraft\Service', function ($mock) {
            $mock->shouldReceive('getItem')->andReturnSelf();
            $mock->shouldReceive('getBody')->andReturnSelf();
            $mock->shouldReceive('getContents')->andReturn('{"id":24358,"name":"QATest +1000 Spell Dmg Ring"}');
        });

        $repository = $this->app->make(ItemRepositoryInterface::class);

        $item = $repository->find(24358);

        $this->assertInstanceOf(Item::class, $item);
        $this->assertNotNull($item->getAttribute('id'));
        $this->assertIsInt($item->id);
        $this->assertEquals(24358, $item->id);
        $this->assertNotNull($item->getAttribute('name'));
        $this->assertEquals('QATest +1000 Spell Dmg Ring', $item->name);
    }

    public function testWithMediaFunction()
    {
        $repository = $this->app->make(ItemRepositoryInterface::class);

        $this->assertObjectHasAttribute('with_media', $repository);
        $this->assertInstanceOf(ItemRepositoryInterface::class, $repository->withMedia());
    }

    public function testWithMediaFunction2()
    {
        $this->mock('App\Blizzard\Warcraft\Service', function ($mock) {
            $mock->shouldReceive('getItem->getBody->getContents')->andReturn('{"id":24358,"media":{"key":{"href":"https://eu.api.blizzard.com/data/wow/media/item/24358?namespace=static-1.13.4_33598-classic-eu"},"id":24358,"assets":[{"key":"icon","value":"https://render-classic-eu.worldofwarcraft.com/icons/56/inv_jewelry_ring_38.jpg"}]}}');
            $mock->shouldReceive('getItemMedia->getBody->getContents')->andReturn('{"_links":{"self":{"href":"https://eu.api.blizzard.com/data/wow/media/item/24358?namespace=static-1.13.4_33598-classic-eu"}},"assets":[{"key":"icon","value":"https://render-classic-eu.worldofwarcraft.com/icons/56/inv_jewelry_ring_38.jpg"}]}');
        });

        $repository = $this->app->make(ItemRepositoryInterface::class);

        $item = $repository->withMedia()->find(24358);

        $this->assertInstanceOf(Item::class, $item);
        $this->assertNotNull($item->getAttribute('media'));
        $this->assertIsObject($item->media);
        $this->assertObjectHasAttribute('assets', $item->media);
        $this->assertIsArray($item->media->assets);
        $this->assertCount(1, $item->media->assets);

        $asset = array_shift($item->media->assets);

        $this->assertIsObject($asset);
        $this->assertObjectHasAttribute('key', $asset);
        $this->assertEquals('icon', $asset->key);
        $this->assertObjectHasAttribute('value', $asset);
        $this->assertEquals('https://render-classic-eu.worldofwarcraft.com/icons/56/inv_jewelry_ring_38.jpg', $asset->value);
    }
}
