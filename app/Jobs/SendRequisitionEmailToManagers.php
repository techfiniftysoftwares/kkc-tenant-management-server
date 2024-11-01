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
use App\Mail\RequisitionRequestedToManagers;

class SendRequisitionEmailToManagers implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $ticket;

    public function __construct(Ticket $ticket)
    {
        $this->ticket = $ticket;
    }

    public function handle()
    {
        $facilityManager = User::where('facility_id', $this->ticket->facility_id)
            ->where('branch_id', $this->ticket->branch_id)
            ->where('role_id', 1) // Assuming role_id 1 is for Facility Managers
            ->first();

        $storeManager = User::where('facility_id', $this->ticket->facility_id)
            ->where('branch_id', $this->ticket->branch_id)
            ->where('role_id', 5) // Assuming role_id 5 is for Store Managers
            ->first();

        if ($facilityManager) {
            Mail::to($facilityManager->email)->send(new RequisitionRequestedToManagers($this->ticket, $facilityManager));
        }

        if ($storeManager) {
            Mail::to($storeManager->email)->send(new RequisitionRequestedToManagers($this->ticket, $storeManager));
        }
    }
}
