<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class SeeBankStockTest extends DuskTestCase
{
    /**
     * A basic browser test example.
     *
     * @return void
     */
    public function testSeeStock()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/bank')
                    ->assertSee('I\'m looking for an item...')
                    ->click('#btnStepOneDonate')
                    ->assertSee('Below you will find the list of bank characters, so you know where to send each item.');
        });
    }
}
