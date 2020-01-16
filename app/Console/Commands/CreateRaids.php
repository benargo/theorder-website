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
        $filtered = $this->schedules->filter(function ($item) {
            return ($item->starts->diffInDays(Carbon::now()) % $item->repeats_days == 0);
        });

        // Loop through each of the schedules for today...
        $filtered->each(function ($schedule) {
            // Check and add events in the next eight weeks...
            for ($i = 0; $i <= 56; $i = $i + $schedule->repeats_days) {
                $date = Carbon::yesterday();
                $date->addDays($i);
                $date->hour($schedule->starts->hour)
                     ->minute($schedule->starts->minute);

                if ($date->isAfter($schedule->starts))
                {
                    $this->raids[] = Raid::firstOrCreate(
                        ['starts_at' => $date],
                        ['schedule_id' => $schedule->id, 'starts_at' => $date, 'instance_ids' => $schedule->instance_ids]
                    );
                }
            }
        });
    }
}
