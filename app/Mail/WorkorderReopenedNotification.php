<?php

namespace App\Mail;

use App\Models\WorkOrder;
use App\Models\Ticket;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class WorkorderReopenedNotification extends Mailable
{
    use Queueable, SerializesModels;

    public $workOrder;
    public $ticket;
    public $user;

    public function __construct(WorkOrder $workOrder, Ticket $ticket, User $user)
    {
        $this->workOrder = $workOrder;
        $this->ticket = $ticket;
        $this->user = $user;
    }

    public function build()
    {
        return $this->subject('Workorder Reopened and Ticket Updated')
            ->markdown('emails.workorders.reopened');
    }
}
