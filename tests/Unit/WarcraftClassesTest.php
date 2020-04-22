<?php

namespace Tests\Unit;

use App\Blizzard\Warcraft\Classes;
use App\Blizzard\Warcraft\Facades\Classes as ClassesFacade;
use Illuminate\Support\Facades\Cache;
use Tests\TestCase;

class WarcraftClassesTest extends TestCase
{
    public function testServiceProvider()
    {
        Cache::shouldReceive('tags')
             ->zeroOrMoreTimes()
             ->with(['blizzard', 'static'])
             ->andReturnSelf();

        Cache::shouldReceive('has')
             ->once()
             ->with('classes')
             ->andReturn(true);

        Cache::shouldReceive('get')
             ->once()
             ->with('classes')
             ->andReturn(collect([]));

        $classes = $this->app->make(Classes::class);

        $this->assertInstanceOf(Classes::class, $classes);
    }

    public function testBlizzardClient()
    {
        Cache::shouldReceive('tags')
             ->zeroOrMoreTimes()
             ->with(['blizzard', 'static'])
             ->andReturnSelf();

        Cache::shouldReceive('has')
             ->once()
             ->with('classes')
             ->andReturn(false);

        Cache::shouldReceive('put')
             ->once()
             ->with('classes', \Mockery::type(\Illuminate\Support\Collection::class), \Mockery::type(\DateTimeInterface::class))
             ->andReturnNull();

        $classes = $this->app->make(Classes::class);

        $this->assertInstanceOf(Classes::class, $classes);
        $this->assertInstanceOf(\Illuminate\Support\Collection::class, $classes->getClasses());
    }

    public function testFacade()
    {
        Cache::shouldReceive('tags')
             ->zeroOrMoreTimes()
             ->with(['blizzard', 'static'])
             ->andReturnSelf();

        Cache::shouldReceive('has')
             ->once()
             ->with('classes')
             ->andReturn(true);

        Cache::shouldReceive('get')
             ->once()
             ->with('classes')
             ->andReturn(collect([]));

        $classes = ClassesFacade::getClasses();

        $this->assertInstanceOf(\Illuminate\Support\Collection::class, $classes);
    }
}
