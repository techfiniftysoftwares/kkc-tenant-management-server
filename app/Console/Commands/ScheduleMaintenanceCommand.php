<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Asset;
use App\Models\MaintenanceSchedulingTicket;

class ScheduleMaintenanceCommand extends Command
{
    protected $signature = 'maintenance:schedule';

    public function handle()
    {
        $assets = Asset::where('maintenance_schedule_date', '<=', now()->toDateString())
            ->whereIn('status', ['Active', 'In Use'])
            ->where('maintenance_due', false)
            ->get();

        foreach ($assets as $asset) {
            MaintenanceSchedulingTicket::create([
                // 'asset_id' => $asset->id,


            ]);

            $asset->update([
                'status' => 'Under Maintenance',
                'maintenance_due' => true,
            ]);
        }
    }
}
