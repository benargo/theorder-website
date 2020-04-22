<?php

namespace Tests\Unit;

use App\Blizzard\Warcraft\Races;
use App\Blizzard\Warcraft\Facades\Races as RacesFacade;
use Illuminate\Support\Facades\Cache;
use Tests\TestCase;

class WarcraftRacesTest extends TestCase
{
    public function testServiceProvider()
    {
        Cache::shouldReceive('tags')
             ->zeroOrMoreTimes()
             ->with(['blizzard', 'static'])
             ->andReturnSelf();

        Cache::shouldReceive('has')
             ->once()
             ->with('races')
             ->andReturn(true);

        Cache::shouldReceive('get')
             ->once()
             ->with('races')
             ->andReturn(collect([]));

        $races = $this->app->make(Races::class);

        $this->assertInstanceOf(Races::class, $races);
    }

    public function testBlizzardClient()
    {
        Cache::shouldReceive('tags')
             ->zeroOrMoreTimes()
             ->with(['blizzard', 'static'])
             ->andReturnSelf();

        Cache::shouldReceive('has')
             ->once()
             ->with('races')
             ->andReturn(false);

        Cache::shouldReceive('put')
             ->once()
             ->with('races', \Mockery::type(\Illuminate\Support\Collection::class), \Mockery::type(\DateTimeInterface::class))
             ->andReturnNull();

        $races = $this->app->make(Races::class);

        $this->assertInstanceOf(Races::class, $races);
        $this->assertInstanceOf(\Illuminate\Support\Collection::class, $races->getRaces());
    }

    public function testFacade()
    {
        Cache::shouldReceive('tags')
             ->zeroOrMoreTimes()
             ->with(['blizzard', 'static'])
             ->andReturnSelf();

        Cache::shouldReceive('has')
             ->once()
             ->with('races')
             ->andReturn(true);

        Cache::shouldReceive('get')
             ->once()
             ->with('races')
             ->andReturn(collect([]));

        $races = RacesFacade::getRaces();

        $this->assertInstanceOf(\Illuminate\Support\Collection::class, $races);
    }
}
