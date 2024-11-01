<?php

namespace App\Console\Commands;

use App\Jobs\SendTicketNotificationsJob;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class SendTicketNotificationsCommand extends Command
{
    protected $signature = 'tickets:send-notifications';
    protected $description = 'Send ticket notifications to facility managers';

    public function handle()
    {
        $this->info('Sending ticket notifications...');

        dispatch(new SendTicketNotificationsJob());

        $this->info('Ticket notifications sent.');
    }
}
