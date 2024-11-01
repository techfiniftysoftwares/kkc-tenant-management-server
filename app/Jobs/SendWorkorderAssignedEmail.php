<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Models\WorkOrder;
use App\Models\Ticket;
use App\Models\Technician;
use App\Notifications\WorkorderAssignedNotification;

class SendWorkorderAssignedEmail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $workorder;
    protected $ticket;
    protected $technician;

    /**
     * Create a new job instance.
     *
     * @param  \App\Models\Workorder  $workorder
     * @param  \App\Models\Ticket  $ticket
     * @param  \App\Models\Technician  $technician
     * @return void
     */
    public function __construct(Workorder $workorder, Ticket $ticket, Technician $technician)
    {
        $this->workorder = $workorder;
        $this->ticket = $ticket;
        $this->technician = $technician;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
{
    $this->technician->notify(new WorkorderAssignedNotification($this->workorder, $this->ticket));
}
}
