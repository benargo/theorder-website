<?php

namespace App\Console\Commands;

use App;
use Carbon\Carbon;
use App\Raiding\Raid;
use App\Raiding\Schedule as RaidingSchedule;
use App\Jobs\CloseRaidSignups;
use Illuminate\Console\Command;
use App\Notifications\RaidSignUpsClosed;
use App\Notifications\RaidSignUpsAvailable;
use App\Discord\Channels\RaidSignupsChannel;
use Illuminate\Support\Facades\Notification;

class CreateRaids extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'raids:create';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Schedule new raids using the defined schedules';

    /**
     * The array of raids.
     *
     * @var array
     */
    protected $raids = [];

    /**
     * The collection of schedules.
     *
     * @var \Illuminate\Database\Eloquent\Collection
     */
    protected $schedules;

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->schedules = RaidingSchedule::all();

        // Check and add events in the next eight weeks...
        for ($i = 0; $i <= 56; $i++) {
            // Loop through each of the schedules for today...
            $this->schedules->each(function ($schedule) use ($i) {
                $date = Carbon::today();
                $date->addDays($i);
                $date->hour($schedule->starts->hour)
                     ->minute($schedule->starts->minute);

                if (
                    $date->gte($schedule->starts) &&
                    $schedule->starts->diffInDays($date) % $schedule->repeats_days == 0
                ) {
                    $raid = Raid::firstOrCreate(
                        ['starts_at' => $date],
                        [
                            'schedule_id' => $schedule->id,
                            'starts_at' => $date,
                            'num_tanks' => $schedule->num_tanks,
                            'num_tanks_druid' => $schedule->num_tanks_druid,
                            'num_tanks_paladin' => $schedule->num_tanks_paladin,
                            'num_tanks_warrior' => $schedule->num_tanks_warrior,
                            'num_healers' => $schedule->num_healers,
                            'num_healers_druid' => $schedule->num_healers_druid,
                            'num_healers_paladin' => $schedule->num_healers_paladin,
                            'num_healers_priest' => $schedule->num_healers_priest,
                            'num_damage' => $schedule->num_damage,
                            'num_damage_druid' => $schedule->num_damage_druid,
                            'num_damage_hunter' => $schedule->num_damage_hunter,
                            'num_damage_mage' => $schedule->num_damage_mage,
                            'num_damage_paladin' => $schedule->num_damage_paladin,
                            'num_damage_priest' => $schedule->num_damage_priest,
                            'num_damage_rogue' => $schedule->num_damage_rogue,
                            'num_damage_warlock' => $schedule->num_damage_warlock,
                            'num_damage_warrior' => $schedule->num_damage_warrior,
                            'instance_ids' => $schedule->instance_ids,
                        ]
                    );

                    if ($raid->wasRecentlyCreated) {
                        $this->info("Raid #{$raid->id} created using schedule ID {$schedule->id}, on {$date->toDateTimeString()}");

                        $discord_channel = App::make(RaidSignupsChannel::class);

                        // Create the notification for when raid signups open...
                        $opening_date = $date->subDays(6)->hour(10)->minute(0)->second(0);

                        if ($opening_date->isAfter(Carbon::now())) {

                            $discord_channel->notify((new RaidSignUpsAvailable($raid))->delay($opening_date));
                        }
                        
                        // Schedule the job for when signups close...
                        CloseRaidSignups::dispatch($raid)
                                ->delay($date->subHours(24));

                        $this->info("Scheduled the job for closing raid signups");
                    }
                    else {
                        $this->comment("Skipped creating raid as it already exists as #{$raid->id}");
                    }

                    // Add the raid to the list of raids...
                    $this->raids[] = $raid;
                }
            });
        }
    }
}
