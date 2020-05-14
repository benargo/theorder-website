<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class SeeBankersTest extends DuskTestCase
{
    public function testSeeBankers()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/bank')
                    ->assertSee('I want to donate items...')
                    ->click('#btnStepOneDonate')
                    ->assertSee('Below you will find the list of bank characters, so you know where to send each item.');
        });
    }
}
