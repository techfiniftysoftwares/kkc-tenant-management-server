<?php

namespace App\Jobs;

use App\Models\Ticket;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;
use App\Mail\IncidentReportedToFacilityManager;

class SendIncidentEmailToFacilityManagers implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $ticket;

    public function __construct(Ticket $ticket)
    {
        $this->ticket = $ticket;
    }

    public function handle()
    {
        $facilityManagers = User::where('facility_id', $this->ticket->facility_id)
            ->where('branch_id', $this->ticket->branch_id)
            ->where('role_id', 1) // Assuming role_id 1 is for facility managers
            ->get();

        foreach ($facilityManagers as $facilityManager) {
            Mail::to($facilityManager->email)->send(new IncidentReportedToFacilityManager($this->ticket, $facilityManager));
        }
    }
}
