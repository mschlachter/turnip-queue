<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\TurnipSeeker;

class PurgeAbandonnedSeekers extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'queue:purge-seekers';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Mark seekers as having left the queue if they\'ve been inactive for >= 2 minutes';

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
     * @return int
     */
    public function handle()
    {
        $seekersToPurge = TurnipSeeker::where('left_queue', false)->where('last_ping', '<=', now()->addMinutes(-2));
        if ($seekersCount = $seekersToPurge->count()) {
            foreach ($seekersToPurge->get() as $turnipSeeker) {
                $turnipSeeker->update(['left_queue' => true]);
            }
            $this->info('Seekers purged from queues: ' . $seekersCount);
        }
        return $seekersCount;
    }
}
