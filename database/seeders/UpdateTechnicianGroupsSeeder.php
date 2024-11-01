<?php

namespace Database\Seeders;

use App\Models\Technician;
use App\Models\TechnicianGroup;
use App\Models\TechnicianType;
use Illuminate\Database\Seeder;

class UpdateTechnicianGroupsSeeder extends Seeder
{
    public function run()
    {
        // Get all technician types
        $technicianTypes = TechnicianType::all();

        // Create technician groups based on technician types
        foreach ($technicianTypes as $technicianType) {
            $group = TechnicianGroup::firstOrCreate(
                ['name' => $technicianType->name . ' Group'],
                ['name' => $technicianType->name . ' Group']
            );

            // Get technicians with the current technician type
            $technicians = Technician::where('technician_type_id', $technicianType->id)->get();

            // Update technician_group_id for each technician
            foreach ($technicians as $technician) {
                $technician->technician_group_id = $group->id;
                $technician->save();
            }
        }
    }
}