<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\NewsItem;

class NewsIndexPageTest extends TestCase
{
    public function testPageWithoutModels()
    {
        $response = $this->get('/news');

        $response->assertOk();
    }

    public function testPageWithModels()
    {
        factory(NewsItem::class, 3)->make();

        $response = $this->get('/news');

        $response->assertOk();
    }
}
