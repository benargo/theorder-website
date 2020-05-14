<?php

namespace Tests\Feature;

use App\User;
use Tests\TestCase;

class JoinPageTest extends TestCase
{
    public function testResponse()
    {
        $response = $this->get('/join');

        $response->assertRedirect('login');
    }

    public function testResponseWhenAuthenticated()
    {
        $user = factory(User::class)->make();

        $response = $this->actingAs($user)->get('/join');

        $response->assertOk();
    }
}
