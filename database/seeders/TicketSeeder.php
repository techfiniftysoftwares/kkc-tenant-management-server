<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TicketSeeder extends Seeder
{
    public function run()
    {
        // Fetch all incident type IDs
        $incidentTypeIds = DB::table('incident_types')->pluck('id')->toArray();

        // Fetch existing tickets
        $existingTickets = DB::table('tickets')->get();

        foreach ($existingTickets as $ticket) {
            // Randomly select an incident type ID
            $incidentTypeId = $incidentTypeIds[array_rand($incidentTypeIds)];

            // Update the ticket with the randomly selected incident_type_id
            DB::table('tickets')
                ->where('id', $ticket->id)
                ->update([
                    'incident_type_id' => $incidentTypeId,
                ]);
        }
    }
}
