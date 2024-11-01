<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class WorkorderClosedToTicketCreatorMail extends Notification implements ShouldQueue
{
    use Queueable;

    public $workorder;
    public $ticket;

    /**
     * Create a new notification instance.
     *
     * @param \App\Models\Workorder $workorder
     * @param \App\Models\Ticket $ticket
     */
    public function __construct($workorder, $ticket)
    {
        $this->workorder = $workorder;
        $this->ticket = $ticket;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('Workorder Closed for Your Ticket')
            ->line('The workorder assigned for your ticket has been closed:')
            ->line('Ticket Number: ' . $this->ticket->ticket_number)
            ->line('Workorder Number: ' . $this->workorder->workorder_no)
            ->line('Your issue has been addressed by the technician.');
    }
}
