<?php

namespace Tests\Feature;

use Tests\TestCase;

class BankIndexPageTest extends TestCase
{
    public function testPage()
    {
        $response = $this->get('/bank');

        $response->assertOk();
    }
}
