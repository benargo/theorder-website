<?php

namespace Tests\Unit;


use Tests\TestCase;
use App\User;
use App\Guild\Bank\Stock;
use Illuminate\Foundation\Testing\RefreshDatabase;

class GetGuildBankStockTest extends TestCase
{
    use RefreshDatabase;

    public function testGetAsGuest()
    {
        $response = $this->json('GET', '/api/guild-bank/stock');

        $response->assertStatus(401);
    }

    public function testGetAsUser()
    {
        $user = factory(User::class)->create();

        $response = $this->actingAs($user, 'api')->json('GET', '/api/guild-bank/stock');

        $response->assertStatus(200); // 'OK'
    }

    public function testResponseHasExpectedFormat()
    {
        $user = factory(User::class)->create();

        $response = $this->actingAs($user, 'api')->json('GET', '/api/guild-bank/stock');

        $response->assertJsonStructure([
            'stock' => factory(Stock::class, 5)->make()->toArray(),
        ]);
    }
}
