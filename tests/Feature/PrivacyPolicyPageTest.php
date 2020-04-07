<?php

namespace Tests\Feature;

use Tests\TestCase;

class PrivacyPolicyPageTest extends TestCase
{
    public function testPage()
    {
        $response = $this->get('/privacy');

        $response->assertOk();
    }
}
