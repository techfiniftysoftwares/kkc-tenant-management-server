<?php

namespace App\Mail;

use App\Models\Ticket;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class TicketRejectedNotification extends Mailable
{
    use Queueable, SerializesModels;

    public $ticket;
    public $user;
    public $reason;

    public function __construct(Ticket $ticket, User $user, string $reason)
    {
        $this->ticket = $ticket;
        $this->user = $user;
        $this->reason = $reason;
    }

    public function build()
    {
        return $this->subject('Your Ticket Has Been Rejected')
            ->markdown('emails.tickets.rejected');
    }
}
