<?php

namespace Tests\Feature;


use Tests\TestCase;
use App\User;
use App\Guild\Bank\Stock;
use Illuminate\Foundation\Testing\RefreshDatabase;

class GetGuildBankStockApiTest extends TestCase
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
        $stock = factory(Stock::class, 5)->create()->toArray();
        $row_structure = [
            'banker',
            'bag',
            'mail',
            'slot',
            'item',
            'count',
            'created_at',
            'updated_at',
        ];

        $response = $this->actingAs($user, 'api')->json('GET', '/api/guild-bank/stock');

        $response->assertJsonStructure([
            'stock' => [
                $row_structure,
                $row_structure,
                $row_structure,
                $row_structure,
                $row_structure,
            ]
        ]);
    }
}
