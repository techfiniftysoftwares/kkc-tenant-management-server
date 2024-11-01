<?php

namespace App\Jobs;

use App\Models\WorkOrder;
use App\Models\TechnicianGroup;
use App\Models\Technician;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;
use App\Mail\WorkorderAssignedToTechnicianGroupNotification;

class SendWorkorderAssignedToTechnicianGroupNotification implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $workorder;
    protected $technicianGroup;

    public function __construct(Workorder $workorder, TechnicianGroup $technicianGroup)
    {
        $this->workorder = $workorder;
        $this->technicianGroup = $technicianGroup;
    }

    public function handle()
    {
        $technicians = Technician::where('technician_group_id', $this->technicianGroup->id)
            ->with('user')
            ->get();

        foreach ($technicians as $technician) {
            if ($technician->user) {
                Mail::to($technician->user->email)->send(new WorkorderAssignedToTechnicianGroupNotification($this->workorder, $this->technicianGroup, $technician->user));
            }
        }
    }
}
