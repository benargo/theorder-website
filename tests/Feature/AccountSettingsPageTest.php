<?php

namespace Tests\Feature;

use App\User;
use Tests\TestCase;

class AccountSettingsPageTest extends TestCase
{
    /**
     * Tests the redirection of the '/account' URL to '/account/settings'.
     *
     * @return void
     */
    public function testRedirect()
    {
        $response = $this->get('/account');

        $response->assertRedirect('/account/settings');
    }

    public function testResponse()
    {
        $response = $this->get('/account/settings');

        $response->assertRedirect('/login');
    }

    public function testResponseWhenAuthenticated()
    {
        $user = factory(User::class)->make();

        $response = $this->actingAs($user)->get('/account/settings');

        $response->assertOk();
    }
}
