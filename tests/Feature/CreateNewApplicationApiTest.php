<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\User;
use Illuminate\Support\Facades\Notification;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CreateNewApplicationApiTest extends TestCase
{
    public function testCreateAsGuest()
    {
        $response = $this->json('POST', '/api/applications/new', []);

        $response->assertStatus(401);
        $response->assertJson(['message' => "Unauthenticated."]);
    }

    public function testCreateWithMissingData()
    {
        $user = factory(User::class)->create();

        $response = $this->actingAs($user, 'api')->json('POST', '/api/applications/new', []);

        $response->assertStatus(422);
    }

    public function testCreateWithInvalidClassId()
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

    public function testCreateWithInvalidRaceId()
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

    public function testCreateWithInvalidRole()
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

    public function testCreateWithValidData()
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
