<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\WorkOrder;
use App\Models\Ticket;

class WorkorderAssigned extends Mailable
{
    use Queueable, SerializesModels;

    public $workorder;
    public $ticket;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Workorder $workorder, Ticket $ticket)
    {
        $this->workorder = $workorder;
        $this->ticket = $ticket;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
   public function build()
    {
        return $this->from(env('MAIL_FROM_ADDRESS'), env('MAIL_FROM_NAME'))
                    ->view('emails.assigned')
                    ->subject('New Workorder Assigned')
                    ->with([
                        'workorder' => $this->workorder,
                        'ticket' => $this->ticket,
                    ]);
    }
}
