<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use App\Models\Ticket;




class IncidentReported implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $ticket;

    public function __construct(Ticket $ticket)
    {
        $this->ticket = $ticket;
    }

    public function broadcastOn()
    {
        return new Channel('incidents');
    }

    public function broadcastAs()
    {
        return 'incident.reported';
    }

    public function broadcastWith()
    {
        return [
            'ticket_number' => $this->ticket->ticket_number,
            'description' => $this->ticket->description,
        ];
    }
}
