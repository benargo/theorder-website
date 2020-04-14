<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\User;

class JoinPageTest extends TestCase
{
    public function testPageAsGuest()
    {
        $response = $this->get('/join');

        $response->assertRedirect('login');
    }

    public function testPageAsUser()
    {
        $user = factory(User::class)->make();

        $response = $this->actingAs($user)->get('/join');

        $response->assertOk();
    }
}
