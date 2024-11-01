<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use App\Console\Commands\RunSpecificMigrations;

class Kernel extends ConsoleKernel
{



    protected $commands = [
        RunSpecificMigrations::class,
    ];
    protected function schedule(Schedule $schedule): void
    {
        // Schedule the CheckReorderLevel command to run daily
        $schedule->command('app:check-reorder-level')->daily();

        // // Schedule the CheckOverdueTicketsCommand to run every minute
        // $schedule->command('tickets:check-overdue')->everyMinute();

        // // Schedule the SendTicketNotificationsCommand to run every 30 minutes
        // $schedule->command('tickets:send-notifications')->everyThirtyMinutes();
        // $schedule->command('tickets:send-notifications')->everyMinute()->withoutOverlapping(30);

        // // Schedule the SendWorkorderTurnaroundNotificationsCommand to run every 30 minutes
        // $schedule->command('workorders:send-turnaround-notifications')->everyThirtyMinutes();
        // $schedule->command('workorders:send-turnaround-notifications')->everyMinute()->withoutOverlapping(30);

        $schedule->command('app:process-depreciation')->daily();
        $schedule->command('maintenance:schedule')->daily();
    }




    protected function commands(): void
    {
        $this->load(__DIR__ . '/Commands');

        require base_path('routes/console.php');
    }
}
