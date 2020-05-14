<?php

namespace Tests\Feature;

use Tests\TestCase;

class PrivacyPolicyPageTest extends TestCase
{
    public function testResponse()
    {
        $response = $this->get('/privacy');

        $response->assertOk();
    }
}
