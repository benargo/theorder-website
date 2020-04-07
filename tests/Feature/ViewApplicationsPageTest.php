<?php

namespace Tests\Feature;

use App\Models\User;
use Tests\TestCase;

class ViewApplicationsPageTest extends TestCase
{
    public function testAuthorizationAsGuest()
    {
        $response = $this->get('/officers/applications');

        $response->assertForbidden();
    }

    public function testAuthorizationAsNormie()
    {
        $user = factory(User::class)->make();

        $response = $this->actingAs($user)->get('/officers/applications');

        $response->assertForbidden();
    }

    public function testAuthorizationAsCommander()
    {
        $user = factory(User::class)->state('commander')->make();

        $response = $this->actingAs($user)->get('/officers/applications');

        $response->assertOk();
    }

    public function testAuthorizationAsInnerCircle()
    {
        $user = factory(User::class)->state('inner_circle')->make();

        $response = $this->actingAs($user)->get('/officers/applications');

        $response->assertOk();
    }
}
