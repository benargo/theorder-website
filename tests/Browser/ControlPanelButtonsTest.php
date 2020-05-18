<?php

namespace Tests\Browser;

use App\User;
use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class ControlPanelButtonsTest extends DuskTestCase
{
    use DatabaseMigrations;

    private $user;

    public function setUp():void
    {
        parent::setUp();

        $this->user = factory(User::class)->state('commander')->create();
    }

    public function testCanSeePage()
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs($this->user)
                    ->visit('/officers')
                    ->assertSee('Control Panel');
        });
    }

    public function testManageGuildRanksButton()
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs($this->user)
                    ->visit('/officers')
                    ->assertSeeLink('Manage guild ranks')
                    ->clickLink('Manage guild ranks')
                    ->assertPathIs('/officers/ranks');
        });
    }
}
