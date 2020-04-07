<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\NewsItem;
use Illuminate\Foundation\Testing\RefreshDatabase;

class NewsSinglePageTest extends TestCase
{
    use RefreshDatabase;

    public function testPageUsingId()
    {
        $item = factory(NewsItem::class)->make();
        $item->author()->associate(factory(User::class)->create());
        $item->save();

        $response = $this->get("/news/{$item->id}");

        $response->assertOk();
    }

    public function testPageUsingSlug()
    {
        $item = factory(NewsItem::class)->make();
        $item->author()->associate(factory(User::class)->create());
        $item->save();

        $response = $this->get("/news/{$item->url}");

        $response->assertOk();
    }
}
