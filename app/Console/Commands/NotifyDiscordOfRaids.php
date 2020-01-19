<?php

namespace App\Console\Commands;

use App;
use Carbon\Carbon;
use App\Raiding\Raid;
use Illuminate\Console\Command;
use App\Notifications\RaidSignUpsAvailable;
use App\Discord\Channels\RaidSignupsChannel;
use Illuminate\Support\Facades\Notification;

class NotifyDiscordOfRaids extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'raids:notify';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send notifications to Discord about raids.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->sendRaidSignUpsAvailableNotifications();
    }

    private function sendRaidSignUpsAvailableNotifications()
    {
        // $raids = Raid::where('starts_at', Carbon::now()->subWeek());
        $raids = Raid::all()->take(1);

        $raids->each(function ($raid) {
            Notification::send([App::make(RaidSignupsChannel::class)], new RaidSignUpsAvailable($raid));
        });
    }
}
