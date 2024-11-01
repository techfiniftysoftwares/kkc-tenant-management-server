<?php

namespace App\Jobs;

use App\Models\Ticket;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class CheckOverdueTickets implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function handle()
    {
        $tickets = Ticket::whereNotIn('status', ['Overdue', 'Immediate', 'Open'])->get();

        foreach ($tickets as $ticket) {
            $createdAt = Carbon::parse($ticket->created_at);
            $turnaroundTime = $this->parseTurnaroundTime($ticket->turnaround_time);

            if ($turnaroundTime !== 0 && $createdAt->addMinutes($turnaroundTime)->isPast()) {
                $ticket->status = 'Overdue';
                $ticket->save();

                Log::info('Updated ticket status to Overdue', ['ticket_id' => $ticket->id]);
            }
        }
    }
    private function parseTurnaroundTime(string $turnaroundTime)
    {
        if ($turnaroundTime === 'Immediate') {
            return 0; // Immediate turnaround time should be treated as 0 minutes
        }

        $pattern = '/^(\d+)\s*(minute|hour|day)s?$/';
        if (preg_match($pattern, $turnaroundTime, $matches)) {
            $value = (int) $matches[1];
            $unit = $matches[2];

            switch ($unit) {
                case 'minute':
                    return $value;
                case 'hour':
                    return $value * 60;
                case 'day':
                    return $value * 1440;
            }
        }

        return 0; // Return 0 if the turnaround time format is not recognized
    }
}
