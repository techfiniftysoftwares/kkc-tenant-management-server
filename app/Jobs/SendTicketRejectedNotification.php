<?php

namespace App\Jobs;

use App\Models\Ticket;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;
use App\Mail\TicketRejectedNotification;

class SendTicketRejectedNotification implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $ticket;
    protected $reason;

    public function __construct(Ticket $ticket, string $reason)
    {
        $this->ticket = $ticket;
        $this->reason = $reason;
    }

    public function handle()
    {
        $user = User::findOrFail($this->ticket->raised_by);
        Mail::to($user->email)->send(new TicketRejectedNotification($this->ticket, $user, $this->reason));
    }
}
