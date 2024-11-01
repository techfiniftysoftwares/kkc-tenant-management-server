<?php

namespace App\Mail;

use App\Models\WorkOrder;
use App\Models\Ticket;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class WorkorderOpenedNotification extends Mailable
{
    use Queueable, SerializesModels;

    public $workorder;
    public $ticket;
    public $user;

    public function __construct(Workorder $workorder, Ticket $ticket, User $user)
    {
        $this->workorder = $workorder;
        $this->ticket = $ticket;
        $this->user = $user;
    }

    public function build()
    {
        return $this->subject('Your Ticket Has Been Opened: Workorder Created')
            ->markdown('emails.workorders.opened');
    }
}
