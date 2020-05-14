<?php

namespace Tests\Feature;

use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Mockery;
use Tests\TestCase;

class UpdateStockApiTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Contains the user model for authentication...
     */
    private $user;

    public function setUp(): void
    {
        parent::setUp();

        $this->user = factory(User::class)->states('inner_circle')->create();

        DB::table('bankers')->insert([
            ['name' => 'Theorder', 'position' => 0, 'created_at' => now()],
        ]);
    }

    public function testPostUpdateStock()
    {
        $mock_items = Mockery::mock('App\Repositories\ItemRepository');
        $mock_items->shouldReceive('find')
                   ->with(7005)
                   ->twice()
                   ->andReturn(['id' => 7005]);
        $mock_items->shouldReceive('find')
                   ->with(5956)
                   ->twice()
                   ->andReturn(['id' => 5956]);
        $this->app->instance('App\Repositories\Interfaces\ItemRepositoryInterface', $mock_items);

        $response = $this->actingAs($this->user, 'api')->postJson('/api/guild-bank/stock/update', ['stock' => json_encode((object)[
            'stock' => (object)[
                'mail' => [
                    (object)[
                        'id' => 7005,
                        'name' => 'Skinning Knife',
                        'link' => '|cffffffff|Hitem:7005::::::::120:::::|h[Skinning Knife]|h|r',
                        'count' => 1,
                        'mail' => 0,
                        'slot' => 0,
                        'banker_name' => 'Theorder',
                    ],
                    (object)[
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
                    (object)[
                        'id' => 7005,
                        'name' => 'Skinning Knife',
                        'link' => '|cffffffff|Hitem:7005::::::::120:::::|h[Skinning Knife]|h|r',
                        'count' => 1,
                        'bag' => 0,
                        'slot' => 0,
                        'banker_name' => 'Theorder',
                    ],
                    (object)[
                        'id' => 5956,
                        'name' => 'Blacksmith Hammer',
                        'link' => '|cffffffff|Hitem:5956:0:0:0|h[Blacksmith Hammer]|h|r',
                        'count' => 1,
                        'bag' => 1,
                        'slot' => 1,
                        'banker_name' => 'Theorder',
                    ]
                ]
            ]
        ])]);

        $response->assertOk();
    }

    public function testPostWithEmptyData()
    {
        $response = $this->actingAs($this->user, 'api')->postJson('/api/guild-bank/stock/update', ['stock' => json_encode((object)[
            'stock' => (object)[
                'bags' => [],
                'mail' => []
            ]
        ])]);

        $response->assertOk();
    }

    public function testResponse()
    {
        $mock_items = Mockery::mock('App\Repositories\ItemRepository');
        $mock_items->shouldReceive('find')
                   ->with(7005)
                   ->once()
                   ->andReturn(['id' =>  7005]);
        $mock_items->shouldReceive('find')
                   ->with(5956)
                   ->once()
                   ->andReturn(['id' => 5956]);
        $this->app->instance('App\Repositories\Interfaces\ItemRepositoryInterface', $mock_items);

        $response = $this->actingAs($this->user, 'api')->postJson('/api/guild-bank/stock/update', ['stock' => json_encode((object)[
            'stock' => (object)[
                'mail' => [
                    (object)[
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
                    (object)[
                        'id' => 5956,
                        'name' => 'Blacksmith Hammer',
                        'link' => '|cffffffff|Hitem:5956:0:0:0|h[Blacksmith Hammer]|h|r',
                        'count' => 1,
                        'bag' => 1,
                        'slot' => 1,
                        'banker_name' => 'Theorder',
                    ]
                ]
            ]
        ])]);

        $response->assertJson(['status' => 'Accepted']);
    }
}
