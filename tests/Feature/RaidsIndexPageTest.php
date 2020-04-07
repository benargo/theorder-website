<?php

namespace Tests\Feature;

use Tests\TestCase;

class RaidsIndexPageTest extends TestCase
{
    public function testPage()
    {
        $response = $this->get('/raids');

        $response->assertOk();
    }
}
