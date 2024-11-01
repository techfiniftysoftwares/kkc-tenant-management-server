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
use App\Mail\WorkorderAssignedToTechnicianNotification;

class SendWorkorderAssignedToTechnicianNotification implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $workorder;
    protected $user;

    public function __construct(Workorder $workorder, User $user)
    {
        $this->workorder = $workorder;
        $this->user = $user;
    }

    public function handle()
    {
        Mail::to($this->user->email)->send(new WorkorderAssignedToTechnicianNotification($this->workorder, $this->user));
    }
}
