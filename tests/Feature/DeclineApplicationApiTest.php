<?php

namespace Tests\Feature;

use App\Guild\Application;
use App\User;
use Tests\TestCase;

class DeclineApplicationApiTest extends TestCase
{
    private $application;

    public function setUp(): void
    {
        parent::setUp();

        $this->application = factory(Application::class)->states('with_user')->create();
    }

    public function testAsGuest()
    {
        $response = $this->json('PATCH', "/api/applications/{$this->application->id}", ['action' => 'decline']);

        $response->assertStatus(401);
    }

    public function testAsUser()
    {
        $user = factory(User::class)->create();

        $response = $this->actingAs($user, 'api')
                         ->json('PATCH', "/api/applications/{$this->application->id}", ['action' => 'decline']);

        $response->assertStatus(403);
    }

    public function testWithWrongHttpVerb()
    {
        $user = factory(User::class)->states('commander')->create();

        $response = $this->actingAs($user, 'api')
                         ->json('POST', "/api/applications/{$this->application->id}", ['action' => 'decline']);

        $response->assertStatus(405);
    }

    public function testWithInvalidData()
    {
        $user = factory(User::class)->states('commander')->create();

        $response = $this->actingAs($user, 'api')
                         ->json('PATCH', "/api/applications/{$this->application->id}", ['action' => 'invalid']);

        $response->assertStatus(422);
    }

    public function testSuccess()
    {
        $user = factory(User::class)->states('commander')->create();

        $response = $this->actingAs($user, 'api')
                         ->json('PATCH', "/api/applications/{$this->application->id}", ['action' => 'decline']);

        $response->assertStatus(204);
    }
}
