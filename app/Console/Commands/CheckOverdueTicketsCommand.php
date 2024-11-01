<?php

namespace App\Console\Commands;

use App\Jobs\CheckOverdueTickets;
use Illuminate\Console\Command;

class CheckOverdueTicketsCommand extends Command
{
    protected $signature = 'tickets:check-overdue';

    protected $description = 'Check and update overdue tickets';

    public function handle()
    {
        $this->info('Checking overdue tickets...');

        dispatch(new CheckOverdueTickets());

        $this->info('Overdue tickets check completed.');
    }
}
