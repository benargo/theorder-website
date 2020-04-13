<?php

namespace Tests\Unit;

use Tests\DuskTestCase;
use App\Models\User;
use App\Guild\Application;

class DeclineApplicationTest extends DuskTestCase
{
    private $application;

    public function setUp(): void
    {
        parent::setUp();

        $this->application = factory(Application::class)->states('with_user')->create();
    }

    public function testWhileUnauthenticated()
    {
        $response = $this->json('PATCH', "/api/applications/{$this->application->id}", ['action' => 'decline']);

        $response->assertStatus(401);
    }

    public function testWhileUnauthorized()
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
