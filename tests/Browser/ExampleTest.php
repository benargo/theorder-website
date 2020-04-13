<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;
use WowClassesTableSeeder;

class ExampleTest extends DuskTestCase
{
    use DatabaseMigrations;

    /**
     * A basic browser test example.
     *
     * @return void
     */
    public function testBasicExample()
    {
        $this->seed(WowClassesTableSeeder::class);

        $this->browse(function (Browser $browser) {
            $browser->visit('/')
                    ->assertSee('The Order');
        });
    }
}
