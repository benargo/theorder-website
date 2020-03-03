<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class HomePageTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test the page response.
     *
     * @return void
     */
    public function testResponse()
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }
}
