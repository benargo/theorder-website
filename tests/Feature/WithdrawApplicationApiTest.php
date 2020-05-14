<?php

namespace Tests\Feature;

use App\Guild\Application;
use App\User;
use Tests\TestCase;

class WithdrawApplicationApiTest extends TestCase
{
    private $application;

    public function setUp(): void
    {
        parent::setUp();

        $this->application = factory(Application::class)->states('with_user')->create();
    }

    public function testAsGuest()
    {
        $response = $this->json('PATCH', "/api/applications/{$this->application->id}", ['action' => 'withdraw']);

        $response->assertStatus(401);
    }

    public function testAsRegularUser()
    {
        $user = factory(User::class)->create();

        $response = $this->actingAs($user, 'api')
                         ->json('PATCH', "/api/applications/{$this->application->id}", ['action' => 'withdraw']);

        $response->assertStatus(403);
    }

    public function testWithWrongHttpVerb()
    {
        $response = $this->actingAs($this->application->user, 'api')
                         ->json('POST', "/api/applications/{$this->application->id}", ['action' => 'withdraw']);

        $response->assertStatus(405);
    }

    public function testWithInvalidData()
    {
        $response = $this->actingAs($this->application->user, 'api')
                         ->json('PATCH', "/api/applications/{$this->application->id}", ['action' => 'invalid']);

        $response->assertStatus(422);
    }

    public function testSuccess()
    {
        $response = $this->actingAs($this->application->user, 'api')
                         ->json('PATCH', "/api/applications/{$this->application->id}", ['action' => 'withdraw']);

        $response->assertStatus(204);
    }
}
