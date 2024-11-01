<?php

namespace App\Console\Commands;

use App\Jobs\SendWorkorderTurnaroundNotifications;
use App\Models\WorkOrder;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class SendWorkorderTurnaroundNotificationsCommand extends Command
{
    protected $signature = 'workorders:send-turnaround-notifications';
    protected $description = 'Send workorder turnaround notifications for open workorders';

    public function handle()
    {
        $this->info('Checking for open workorders to send notifications...');

        // Get all open workorders
        $openWorkorders = WorkOrder::where('status', 'Open')->get();

        foreach ($openWorkorders as $workorder) {
            dispatch(new SendWorkorderTurnaroundNotifications($workorder, 0));
        }

        $this->info('Open workorder notifications check completed.');
    }
}
