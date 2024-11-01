<?php

namespace App\Jobs;

use App\Models\WorkOrder;
use App\Models\Ticket;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;
use App\Mail\WorkorderCreatedForFacilityManager;
use Spatie\Permission\Models\Role;

class SendWorkorderEmailToFacilityManager implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $workorder;
    protected $ticket;

    public function __construct(Workorder $workorder, Ticket $ticket)
    {
        $this->workorder = $workorder;
        $this->ticket = $ticket;
    }

    public function handle()
    {
        $facilityManagerRole = Role::where('name', 'Facility Manager')->first();
        $facilityManagers = $facilityManagerRole->users;

        foreach ($facilityManagers as $facilityManager) {
            Mail::to($facilityManager->email)->send(new WorkorderCreatedForFacilityManager($this->workorder, $this->ticket, $facilityManager));
        }
    }
}
