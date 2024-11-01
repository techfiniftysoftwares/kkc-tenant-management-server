<?php

namespace App\Notifications;

use App\Models\Ticket;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class TicketOpened extends Notification
{
    use Queueable;

    protected $ticket;

    public function __construct(Ticket $ticket)
    {
        $this->ticket = $ticket;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('Ticket Opened')
            ->line('Your ticket has been opened and assigned to a technician.')
            ->line('Ticket Number: ' . $this->ticket->ticket_number)
            ->line('Description: ' . $this->ticket->description)
            ->line('Thank you for using our application!');
    }
}
