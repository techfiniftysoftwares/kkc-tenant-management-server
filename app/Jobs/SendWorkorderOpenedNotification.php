<?php

namespace App\Jobs;

use App\Models\WorkOrder;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;
use App\Mail\WorkorderOpenedNotification;

class SendWorkorderOpenedNotification implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $workorder;
    protected $ticket;

    public function __construct(Workorder $workorder)
    {
        $this->workorder = $workorder;
        $this->ticket = $workorder->ticket;
    }

    public function handle()
    {
        $ticketRaiser = User::findOrFail($this->ticket->raised_by);
        Mail::to($ticketRaiser->email)->send(new WorkorderOpenedNotification($this->workorder, $this->ticket, $ticketRaiser));
    }
}
