<?php

namespace Tests\Unit;

use Tests\DuskTestCase;
use App\User;
use App\Guild\Application;

class WithdrawApplicationTest extends DuskTestCase
{
    private $application;

    public function setUp(): void
    {
        parent::setUp();

        $this->application = factory(Application::class)->states('with_user')->create();
    }

    public function testWhileUnauthenticated()
    {
        $response = $this->json('PATCH', "/api/applications/{$this->application->id}", ['action' => 'withdraw']);

        $response->assertStatus(401);
    }

    public function testWhileUnauthorized()
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
