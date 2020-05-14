<?php

namespace Tests\Feature;

use App\Models\NewsItem;
use Tests\TestCase;

class NewsIndexPageTest extends TestCase
{
    public function testWithoutModels()
    {
        $response = $this->get('/news');

        $response->assertOk();
    }

    public function testWithModels()
    {
        factory(NewsItem::class, 3)->make();

        $response = $this->get('/news');

        $response->assertOk();
    }
}
