<?php

namespace Tests\Feature;

use App\Models\User;
use Tests\TestCase;

class ControlPanelPageTest extends TestCase
{
    public function testAuthorizationAsGuest()
    {
        $response = $this->get('/officers');

        $response->assertForbidden();
    }

    public function testAuthorizationAsNormie()
    {
        $user = factory(User::class)->make();

        $response = $this->actingAs($user)->get('/officers');

        $response->assertForbidden();
    }

    public function testAuthorizationAsCommander()
    {
        $user = factory(User::class)->state('commander')->make();

        $response = $this->actingAs($user)->get('/officers');

        $response->assertOk();
    }

    public function testAuthorizationAsInnerCircle()
    {
        $user = factory(User::class)->state('inner_circle')->make();

        $response = $this->actingAs($user)->get('/officers');

        $response->assertOk();
    }

    public function testInnerCircleRedirect()
    {
        $user = factory(User::class)->state('inner_circle')->make();

        $response = $this->actingAs($user)->get('/inner-circle');

        $response->assertRedirect('/officers');
    }
}
