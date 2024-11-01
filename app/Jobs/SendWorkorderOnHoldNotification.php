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
use App\Mail\WorkorderOnHoldNotification;

class SendWorkorderOnHoldNotification implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $workOrder;
    protected $ticket;
    protected $comment;

    public function __construct(WorkOrder $workOrder, Ticket $ticket, ?string $comment)
    {
        $this->workOrder = $workOrder;
        $this->ticket = $ticket;
        $this->comment = $comment;
    }

    public function handle()
    {
        $ticketRaiser = User::find($this->ticket->raised_by);
        if ($ticketRaiser) {
            Mail::to($ticketRaiser->email)->send(new WorkorderOnHoldNotification($this->workOrder, $this->ticket, $ticketRaiser, $this->comment));
        }
    }
}
