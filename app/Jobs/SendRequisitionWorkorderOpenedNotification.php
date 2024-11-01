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
use App\Mail\RequisitionWorkorderOpenedNotification;

class SendRequisitionWorkorderOpenedNotification implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $workOrder;
    protected $ticket;

    public function __construct(WorkOrder $workOrder, Ticket $ticket)
    {
        $this->workOrder = $workOrder;
        $this->ticket = $ticket;
    }

    public function handle()
    {
        $ticketRaiser = User::find($this->ticket->raised_by);
        if ($ticketRaiser) {
            Mail::to($ticketRaiser->email)->send(new RequisitionWorkorderOpenedNotification($this->workOrder, $this->ticket, $ticketRaiser));
        }
    }
}
