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
}
