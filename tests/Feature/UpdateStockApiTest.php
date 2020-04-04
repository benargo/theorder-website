<?php

namespace Tests\Feature;

use DB;
use Mockery;
use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UpdateStockApiTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Contains the user model for authentication...
     */
    private $user;

    public function setUp()
    {
        parent::setUp();

        $this->user = factory(User::class)->states('inner_circle')->create();

        DB::table('bankers')->insert([
            ['name' => 'Theorder', 'position' => 0, 'created_at' => now()],
        ]);
    }

    /**
     * Tests the API endpoint.
     *
     * @return void
     */
    public function testPostUpdateStock()
    {
        $mock_items = Mockery::mock('App\Blizzard\Warcraft\Items');
        $mock_items->shouldReceive('getItem')
                   ->with(7005)
                   ->twice()
                   ->andReturn(['id' => 7005]);
        $mock_items->shouldReceive('getItem')
                   ->with(5956)
                   ->twice()
                   ->andReturn(['id' => 5956]);
        $this->app->instance('App\Blizzard\Warcraft\Items', $mock_items);

        $response = $this->actingAs($this->user, 'api')->postJson('/api/guild-bank/stock/update', ['stock' => [
            'mail' => [
                [
                    'id' => 7005,
                    'name' => 'Skinning Knife',
                    'link' => '|cffffffff|Hitem:7005::::::::120:::::|h[Skinning Knife]|h|r',
                    'count' => 1,
                    'mail' => 0,
                    'slot' => 0,
                    'banker_name' => 'Theorder',
                ],
                [
                    'id' => 5956,
                    'name' => 'Blacksmith Hammer',
                    'link' => '|cffffffff|Hitem:5956:0:0:0|h[Blacksmith Hammer]|h|r',
                    'count' => 1,
                    'mail' => 1,
                    'slot' => 1,
                    'banker_name' => 'Theorder',
                ]
            ],
            'bags' => [
                [
                    'id' => 7005,
                    'name' => 'Skinning Knife',
                    'link' => '|cffffffff|Hitem:7005::::::::120:::::|h[Skinning Knife]|h|r',
                    'count' => 1,
                    'bag' => 0,
                    'slot' => 0,
                    'banker_name' => 'Theorder',
                ],
                [
                    'id' => 5956,
                    'name' => 'Blacksmith Hammer',
                    'link' => '|cffffffff|Hitem:5956:0:0:0|h[Blacksmith Hammer]|h|r',
                    'count' => 1,
                    'bag' => 1,
                    'slot' => 1,
                    'banker_name' => 'Theorder',
                ]
            ]
        ]]);

        $response->assertStatus(200);
    }

    /**
     * Test the API endpoint with empty datasets.
     *
     * @return void
     */
    public function testPostWithEmptyData()
    {
        $response = $this->actingAs($this->user, 'api')->postJson('/api/guild-bank/stock/update', ['stock' => [
            'bags' => [],
            'mail' => []
        ]]);

        $response->assertStatus(200);
    }

    /**
     * Tests that the response is returned in the correct format.
     *
     * @return void
     */
    public function testResponse()
    {
        $mock_items = Mockery::mock('App\Blizzard\Warcraft\Items');
        $mock_items->shouldReceive('getItem')
                   ->with(7005)
                   ->once()
                   ->andReturn(['id' => 7005]);
        $mock_items->shouldReceive('getItem')
                   ->with(5956)
                   ->once()
                   ->andReturn(['id' => 5956]);
        $this->app->instance('App\Blizzard\Warcraft\Items', $mock_items);

        $response = $this->actingAs($this->user, 'api')->postJson('/api/guild-bank/stock/update', ['stock' => [
            'mail' => [
                [
                    'id' => 7005,
                    'name' => 'Skinning Knife',
                    'link' => '|cffffffff|Hitem:7005::::::::120:::::|h[Skinning Knife]|h|r',
                    'count' => 1,
                    'mail' => 0,
                    'slot' => 0,
                    'banker_name' => 'Theorder',
                ]
            ],
            'bags' => [
                [
                    'id' => 5956,
                    'name' => 'Blacksmith Hammer',
                    'link' => '|cffffffff|Hitem:5956:0:0:0|h[Blacksmith Hammer]|h|r',
                    'count' => 1,
                    'bag' => 1,
                    'slot' => 1,
                    'banker_name' => 'Theorder',
                ]
            ]
        ]]);

        $response->assertJson(['status' => 'Accepted']);
    }
}
