<?php

namespace App\Jobs;

use App\Raiding\Raid;
use Illuminate\Bus\Queueable;
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

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Raid $raid)
    {
        $this->raid = $raid;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
         
    }
}
