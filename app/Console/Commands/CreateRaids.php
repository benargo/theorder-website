<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use App\Raiding\Raid;
use App\Raiding\Schedule as RaidingSchedule;
use Illuminate\Console\Command;

class CreateRaids extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'raids:schedule';

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
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();

        $this->schedules = RaidingSchedule::all();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        // Check and add events in the next eight weeks...
        for ($i = 0; $i <= 56; $i++) {
            // Loop through each of the schedules for today...
            $this->schedules->each(function ($schedule) use ($i) {
                $date = Carbon::today();
                $date->addDays($i);
                $date->hour($schedule->starts->hour)
                     ->minute($schedule->starts->minute);

                if (
                    $date->isAfter($schedule->starts) &&
                    $schedule->starts->diffInDays($date) % $schedule->repeats_days == 0
                ) {
                    $this->raids[] = Raid::firstOrCreate(
                        ['starts_at' => $date],
                        ['schedule_id' => $schedule->id, 'starts_at' => $date, 'instance_ids' => $schedule->instance_ids]
                    );

                    $this->info("Raid created using schedule ID {$schedule->id}, on {$date->toDateTimeString()}");
                }
            });
        }
    }
}
