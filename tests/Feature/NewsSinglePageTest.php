<?php

namespace Tests\Feature;

use App\Models\NewsItem;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class NewsSinglePageTest extends TestCase
{
    use RefreshDatabase;

    public function testUsingId()
    {
        $item = factory(NewsItem::class)->make();
        $item->author()->associate(factory(User::class)->create());
        $item->save();

        $response = $this->get("/news/{$item->id}");

        $response->assertOk();
    }

    public function testUsingSlug()
    {
        $item = factory(NewsItem::class)->make();
        $item->author()->associate(factory(User::class)->create());
        $item->save();

        $response = $this->get("/news/{$item->url}");

        $response->assertOk();
    }
}
