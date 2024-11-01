<?php

namespace App\Jobs;

use App\Models\WorkOrder;
use App\Models\TechnicianGroup;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;
use App\Mail\WorkorderCommentsToTechnicianGroup;

class SendWorkorderCommentsToTechnicianGroup implements ShouldQueue
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
        $technicians = $this->technicianGroup->technicians;
        foreach ($technicians as $technician) {
            Mail::to($technician->email)->send(new WorkorderCommentsToTechnicianGroup($this->workorder, $technician));
        }
    }
}
