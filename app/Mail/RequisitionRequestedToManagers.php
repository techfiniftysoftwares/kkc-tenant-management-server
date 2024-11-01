<?php

namespace App\Mail;

use App\Models\Ticket;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class RequisitionRequestedToManagers extends Mailable
{
    use Queueable, SerializesModels;

    public $ticket;
    public $manager;
    public $requisitionTicket;

    public function __construct(Ticket $ticket, User $manager)
    {
        $this->ticket = $ticket;
        $this->manager = $manager;
        $this->requisitionTicket = $ticket->requisitionTicket;
    }

    public function build()
    {
        return $this->subject('New Requisition Request')
            ->markdown('emails.requisitions.requested-to-managers');
    }
}
