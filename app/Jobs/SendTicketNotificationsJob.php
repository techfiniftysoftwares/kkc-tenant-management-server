<?php

namespace App\Jobs;

use App\Models\Ticket;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;
use App\Mail\UnassignedTicketNotification;
use Spatie\Permission\Models\Role;

class SendTicketNotificationsJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function handle()
    {
        $unassignedTickets = Ticket::where('status', 'Unassigned')->get();

        foreach ($unassignedTickets as $ticket) {
            $createdAt = Carbon::parse($ticket->created_at);
            $currentTime = Carbon::now();
            $turnaroundTime = $this->parseTurnaroundTime($ticket->turnaround_time);

            if ($turnaroundTime !== 0) {
                $fiftyPercentTime = $createdAt->copy()->addMinutes($turnaroundTime * 0.5);
                $seventyFivePercentTime = $createdAt->copy()->addMinutes($turnaroundTime * 0.75);
                $hundredPercentTime = $createdAt->copy()->addMinutes($turnaroundTime);

                if ($currentTime->startOfMinute()->equalTo($fiftyPercentTime->startOfMinute())) {
                    $this->sendEmailToFacilityManager($ticket, '50% of turnaround time has passed');
                } elseif ($currentTime->startOfMinute()->equalTo($seventyFivePercentTime->startOfMinute())) {
                    $this->sendEmailToFacilityManager($ticket, '75% of turnaround time has passed');
                } elseif ($currentTime->startOfMinute()->equalTo($hundredPercentTime->startOfMinute())) {
                    $this->sendEmailToFacilityManager($ticket, '100% of turnaround time has passed');
                }
            }
        }
    }

    private function sendEmailToFacilityManager($ticket, $message)
    {
        $facilityManagerRole = Role::where('name', 'Facility Manager')->first();
        $facilityManagers = $facilityManagerRole->users;

        foreach ($facilityManagers as $facilityManager) {
            try {
                Mail::to($facilityManager->email)->send(new UnassignedTicketNotification($ticket, $message, $facilityManager));
            } catch (\Exception $e) {
                // Consider logging this exception in production
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
