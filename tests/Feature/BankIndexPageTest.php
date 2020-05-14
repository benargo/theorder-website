<?php

namespace Tests\Feature;

use App\User;
use Tests\TestCase;

class BankIndexPageTest extends TestCase
{
    public function testResponse()
    {
        $response = $this->get('/bank');

        $response->assertOk();
    }

    public function testResponseWhenAuthenticated()
    {
        $user = factory(User::class)->make();

        $response = $this->actingAs($user)->get('/bank');

        $response->assertOk();
    }
}
