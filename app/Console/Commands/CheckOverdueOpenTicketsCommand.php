<?php

namespace App\Console\Commands;

use App\Jobs\CheckOverdueOpenTickets;
use Illuminate\Console\Command;

class CheckOverdueOpenTicketsCommand extends Command
{
    protected $signature = 'tickets:check-overdue-open';
    protected $description = 'Check and update overdue open tickets';

    public function handle()
    {
        $this->info('Checking overdue open tickets...');
        dispatch(new CheckOverdueOpenTickets());
        $this->info('Overdue open tickets check completed.');
    }
}
