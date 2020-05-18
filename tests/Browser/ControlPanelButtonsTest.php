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

    public function testViewNewApplicantsButton()
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs($this->user)
                    ->visit('/officers')
                    ->assertSeeLink('View new applicants')
                    ->clickLink('View new applicants')
                    ->assertPathIs('/officers/applications')
                    ->assertQueryStringHas('status', 'pending');
        });
    }

    public function testViewAllApplicantsButton()
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs($this->user)
                    ->visit('/officers')
                    ->assertSeeLink('View all applicants')
                    ->clickLink('View all applicants')
                    ->assertPathIs('/officers/applications');
        });
    }

    public function testCreateNewsItemButton()
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs($this->user)
                    ->visit('/officers')
                    ->assertSeeLink('Create a news item')
                    ->clickLink('Create a news item')
                    ->assertPathIs('/officers/news/create');
        });
    }

    public function testEditNewsItemButton()
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs($this->user)
                    ->visit('/officers')
                    ->assertSeeLink('Edit a news item')
                    ->clickLink('Edit a news item')
                    ->assertPathIs('/officers/news');
        });
    }

    public function testSetBankCharactersButton()
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs($this->user)
                    ->visit('/officers')
                    ->assertSeeLink('Set bank characters')
                    ->clickLink('Set bank characters')
                    ->assertPathIs('/officers/guild-bank/bankers');
        });
    }

    public function testUploadBankDataButton()
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs($this->user)
                    ->visit('/officers')
                    ->assertSeeLink('Upload bank data')
                    ->clickLink('Upload bank data')
                    ->assertPathIs('/officers/guild-bank/upload');
        });
    }

    public function testManageApiClientsButton()
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs($this->user)
                    ->visit('/officers')
                    ->assertSee('These settings are intended for developers only. It\'s recommended that you do not touch this zone unless you are an experienced user.')
                    ->assertSeeLink('Manage API Clients & Secrets')
                    ->clickLink('Manage API Clients & Secrets')
                    ->assertPathIs('/officers/guild-bank/clients');
        });
    }
}
