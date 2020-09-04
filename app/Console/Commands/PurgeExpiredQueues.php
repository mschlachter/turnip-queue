<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\TurnipQueue;

class PurgeExpiredQueues extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'queue:purge-queues';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Mark Queues as closed if their expiry time is passed';

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
        $queuesToPurge = TurnipQueue::where('is_open', true)->where('expiry_date', '<', now());
        if($queuesCount = $queuesToPurge->count()) {
            foreach($queuesToPurge->get() as $turnipSeeker) {
                $turnipSeeker->update(['is_open' => false]);
            }
            $this->info('Queues purged: ' . $queuesCount);
        }
        return $queuesCount;
    }
}
