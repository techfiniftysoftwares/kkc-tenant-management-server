<?php

namespace App\Mail;

use App\Models\WorkOrder;
use App\Models\Ticket;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class WorkorderAndTicketClosedNotification extends Mailable
{
    use Queueable, SerializesModels;

    public $workOrder;
    public $ticket;
    public $user;
    public $closedByUser;

    public function __construct(WorkOrder $workOrder, Ticket $ticket, User $user, User $closedByUser)
    {
        $this->workOrder = $workOrder;
        $this->ticket = $ticket;
        $this->user = $user;
        $this->closedByUser = $closedByUser;
    }

    public function build()
    {
        return $this->subject('Workorder and Ticket Closed')
            ->markdown('emails.workorders.closed');
    }
}