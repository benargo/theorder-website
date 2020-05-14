<?php

namespace Tests\Feature;

use App\User;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;

class CreateNewApplicationApiTest extends TestCase
{
    public function testAsGuest()
    {
        $response = $this->json('POST', '/api/applications/new', []);

        $response->assertUnauthorized();
        $response->assertJson(['message' => "Unauthenticated."]);
    }

    public function testWithMissingData()
    {
        $user = factory(User::class)->create();

        $response = $this->actingAs($user, 'api')->json('POST', '/api/applications/new', []);

        $response->assertStatus(422);
    }

    public function testWithInvalidClassId()
    {
        $user = factory(User::class)->create();

        $response = $this->actingAs($user, 'api')->json('POST', '/api/applications/new', [
            'characterName' => 'Jaina',
            'classId' => 'invalid',
            'raceId' => 1,
            'role' => 'damage',
        ]);

        $response->assertStatus(422);
    }

    public function testWithInvalidRaceId()
    {
        $user = factory(User::class)->create();

        $response = $this->actingAs($user, 'api')->json('POST', '/api/applications/new', [
            'characterName' => 'Jaina',
            'classId' => 1,
            'raceId' => 'invalid',
            'role' => 'damage',
        ]);

        $response->assertStatus(422);
    }

    public function testWithInvalidRole()
    {
        $user = factory(User::class)->create();

        $response = $this->actingAs($user, 'api')->json('POST', '/api/applications/new', [
            'characterName' => 'Jaina',
            'classId' => 1,
            'raceId' => 1,
            'role' => 'invalid',
        ]);

        $response->assertStatus(422);
    }

    public function testWithValidData()
    {
        Notification::fake();

        $user = factory(User::class)->create();

        $response = $this->actingAs($user, 'api')->json('POST', '/api/applications/new', [
            'characterName' => 'Jaina',
            'classId' => 1,
            'raceId' => 1,
            'role' => 'damage',
        ]);

        $response->assertStatus(204); // 'Accepted'
    }
}
