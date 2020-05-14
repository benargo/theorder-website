<?php

namespace Tests\Feature;

use App\User;
use Tests\TestCase;

class ViewApplicationsPageTest extends TestCase
{
    public function testAsGuest()
    {
        $response = $this->get('/officers/applications');

        $response->assertForbidden();
    }

    public function testAsRegularUser()
    {
        $user = factory(User::class)->make();

        $response = $this->actingAs($user)->get('/officers/applications');

        $response->assertForbidden();
    }

    public function testAsCommander()
    {
        $user = factory(User::class)->state('commander')->make();

        $response = $this->actingAs($user)->get('/officers/applications');

        $response->assertOk();
    }

    public function testAsInnerCircle()
    {
        $user = factory(User::class)->state('inner_circle')->make();

        $response = $this->actingAs($user)->get('/officers/applications');

        $response->assertOk();
    }
}
