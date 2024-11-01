<?php

namespace App\Jobs;

use App\Models\WorkOrder;
use App\Models\Ticket;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;
use App\Mail\WorkorderAndTicketClosedNotification;

class SendWorkorderAndTicketClosedNotification implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $workOrder;
    protected $ticket;
    protected $closedByUser;

    public function __construct(WorkOrder $workOrder, Ticket $ticket, User $closedByUser)
    {
        $this->workOrder = $workOrder;
        $this->ticket = $ticket;
        $this->closedByUser = $closedByUser;
    }

    public function handle()
    {
        $facilityManager = User::where('facility_id', $this->workOrder->facility_id)
            ->where('branch_id', $this->workOrder->branch_id)
            ->where('role_id', 1) // Assuming role_id 1 is for Facility Managers
            ->first();

        $ticketRaiser = User::find($this->ticket->raised_by);

        if ($facilityManager) {
            Mail::to($facilityManager->email)->send(new WorkorderAndTicketClosedNotification($this->workOrder, $this->ticket, $facilityManager, $this->closedByUser));
        }

        if ($ticketRaiser) {
            Mail::to($ticketRaiser->email)->send(new WorkorderAndTicketClosedNotification($this->workOrder, $this->ticket, $ticketRaiser, $this->closedByUser));
        }
    }
}
