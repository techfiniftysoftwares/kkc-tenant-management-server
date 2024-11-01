<?php

namespace App\Jobs;

use App\Models\WorkOrder;
use App\Models\User;
use App\Models\WorkOrderConsumable;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;
use App\Mail\SparePartsRequestNotification;
use Illuminate\Support\Facades\Log;

class SendSparePartsRequestNotification implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $workorder;

    public function __construct(Workorder $workorder)
    {
        $this->workorder = $workorder;
    }

    public function handle()
    {
        $spareParts = WorkOrderConsumable::where('work_order_id', $this->workorder->id)
            ->with('sparePart')
            ->get();

        $facilityManager = User::where('facility_id', $this->workorder->facility_id)
            ->where('branch_id', $this->workorder->branch_id)
            ->where('role_id', 1) // Assuming role_id 1 is for Facility Managers
            ->first();

        $storeManager = User::where('facility_id', $this->workorder->facility_id)
            ->where('branch_id', $this->workorder->branch_id)
            ->where('role_id', 5) // Assuming role_id 5 is for Store Managers
            ->first();

        if ($facilityManager) {
            Mail::to($facilityManager->email)->send(new SparePartsRequestNotification($this->workorder, $facilityManager, $spareParts));
            Log::info("Spare parts request email sent to Facility Manager: {$facilityManager->email}");
        } else {
            Log::warning("No Facility Manager found for facility_id: {$this->workorder->facility_id}, branch_id: {$this->workorder->branch_id}");
        }

        if ($storeManager) {
            Mail::to($storeManager->email)->send(new SparePartsRequestNotification($this->workorder, $storeManager, $spareParts));
            Log::info("Spare parts request email sent to Store Manager: {$storeManager->email}");
        } else {
            Log::warning("No Store Manager found for facility_id: {$this->workorder->facility_id}, branch_id: {$this->workorder->branch_id}");
        }
    }
}
