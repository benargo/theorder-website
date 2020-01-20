<?php

namespace App\Jobs;

use App\Raiding\Raid;
use Illuminate\Bus\Queueable;
use App\Blizzard\Warcraft\Classes;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class CloseRaidSignups implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * The raid which we're closing signups for.
     *
     * @var App\Raiding\Raid
     */
    protected $raid;

    protected $confirmed;

    protected $classes;

    protected $num_tanks;
    protected $num_healers;
    protected $num_damage;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Raid $raid, Classes $classes)
    {
        $this->raid = $raid;
        $this->confirmed = collect([]);
        $this->classes = $classes->getClassicClasses(config('blizzard.faction'));

        // Calculate the total number of players needed...
        $this->num_tanks = $this->raid->num_tanks;
        $this->num_healers = $this->raid->num_healers;
        $this->num_damage = $this->raid->num_damage;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        // Group the signups by role then class...
        $all_signups = $this->raid->signups()->get()->groupBy(['role', 'class_id']);

        // Loop through each of the roles...
        $all_signups->each(function ($signups_by_role, $role) {
            $num_role = "num_{$role}";

            // Then loop through each of the classes...
            $signups_by_role->each(function ($signups_by_class, $class_id) use ($role, $num_role) {
                $class = $this->classes->get($class_id);
                $class_name = strtolower($class->name);
                $class_field = "num_{$role}_{$class_name}";
                $number_allowed = $this->raid->{$class_field};

                // Take the maximum number of signups allowed at random...
                $random_signups = $signups_by_class->random($number_allowed)->values();

                // Add the signups to the confirmed array...
                $this->confirmed = $this->confirmed->merge($random_signups);

                // Subtract the total so we know how many players are left...
                $this->{$num_role} = $this->{$num_role} - $number_allowed;
            });

            if ($this->{$num_role} > 0) {
                // Flatten the remaining signups and exclude any that are already confirmed...
                $remaining_signups = $signups_by_role->intersect($this->confirmed)->flatten();

                // Take the maximum remaining number of signups allowed at random...
                $random_signups = $remaining_signups->random($this->{$num_role})->values();

                // Add the signups to the confirmed array...
                $this->confirmed = $this->confirmed->merge($random_signups);

                // Set the number of remaining to nil...
                $this->{$num_role} = 0;
            }
        });

        // Loop through all of the confirmed signups and save them against the database...
        $this->confirmed->each(function ($signup, $key) {
            $signup->confirmed_at = now();
            $signup->save();
        });

        // Notify Discord that the raid signups have closed...
        $discord_channel->notify(new RaidSignUpsClosed($raid, $this->confirmed);


    }

    private function takeSignupsOfRoleAndClass($signups, $role, $class)
    {

    }
}
