<?php

namespace Tests\Feature;

use Tests\TestCase;

class BattlenetInformationPageTest extends TestCase
{
    public function testPage()
    {
        $response = $this->get('/battlenet');

        $response->assertOk();
    }
}
