<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\WorkOrder;
use App\Models\Ticket;

class WorkorderAssignedNotification extends Notification
{
    use Queueable;

    protected $workorder;
    protected $ticket;

    /**
     * Create a new notification instance.
     *
     * @param  \App\Models\Workorder  $workorder
     * @param  \App\Models\Ticket  $ticket
     * @return void
     */
    public function __construct(Workorder $workorder, Ticket $ticket)
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
            ->subject('New Workorder Assigned')
            ->markdown('emails.workorder_assigned', [
                'workorder' => $this->workorder,
                'ticket' => $this->ticket,
                'technician' => $notifiable,
            ]);
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
