<?php

namespace App\Mail;

use App\Models\WorkOrder;
use App\Models\Ticket;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class WorkorderOnHoldNotification extends Mailable
{
    use Queueable, SerializesModels;

    public $workOrder;
    public $ticket;
    public $user;
    public $comment;

    public function __construct(WorkOrder $workOrder, Ticket $ticket, User $user, ?string $comment)
    {
        $this->workOrder = $workOrder;
        $this->ticket = $ticket;
        $this->user = $user;
        $this->comment = $comment;
    }

    public function build()
    {
        return $this->subject('Workorder On Hold and Ticket Closed')
            ->markdown('emails.workorders.on-hold');
    }
}
