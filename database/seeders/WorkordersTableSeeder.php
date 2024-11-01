<?php

namespace Database\Seeders;

use App\Models\WorkOrder;
use App\Models\IncidentType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class WorkordersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Fetch all ticket IDs
        $ticketIds = DB::table('tickets')->pluck('id')->toArray();

        // Fetch all technician IDs
        $technicianIds = DB::table('technicians')->pluck('id')->toArray();

        // Truncate the workorders table
        WorkOrder::truncate();

        // Fetch all incident types
        $incidentTypes = IncidentType::all();

        foreach ($incidentTypes as $incidentType) {
            $workorderCount = 1;

            // Fetch ticket IDs for the current incident type
            $ticketIdsForIncidentType = DB::table('tickets')
                ->where('incident_type_id', $incidentType->id)
                ->pluck('id')
                ->toArray();

            foreach ($ticketIdsForIncidentType as $ticketId) {
                $workorder = new Workorder();

                // Generate workorder number
                $initials = '';
                $words = explode(' ', $incidentType->name);
                foreach ($words as $word) {
                    $initials .= strtoupper(substr($word, 0, 1));
                }
                $workorderNumber = 'WO' . $initials . '-' . str_pad($workorderCount, 3, '0', STR_PAD_LEFT);

                $workorder->workorder_no = $workorderNumber;
                $workorder->technician_id = $technicianIds[array_rand($technicianIds)];
                $workorder->ticket_id = $ticketId;

                $workorder->save();

                $workorderCount++;
            }
        }
    }
}
