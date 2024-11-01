<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\MaintenanceChecklistType;

class MaintenanceChecklistTypeSeeder extends Seeder
{
    public function run()
    {
        $types = [
            ['name' => 'General Inspection', 'description' => 'Basic checks applicable to most equipment'],
            ['name' => 'HVAC', 'description' => 'Checks specific to heating, ventilation, and air conditioning systems'],
            ['name' => 'Plumbing', 'description' => 'Checks for plumbing systems and fixtures'],
            ['name' => 'Electrical', 'description' => 'Checks for electrical systems and components'],
            ['name' => 'Elevator', 'description' => 'Checks specific to elevator maintenance'],
            ['name' => 'Fire Protection', 'description' => 'Checks for fire alarms, sprinklers, and other fire safety equipment'],
            ['name' => 'Building Exterior', 'description' => 'Checks for the outside of the building, including roof and walls'],
            ['name' => 'Interior Finishes', 'description' => 'Checks for floors, walls, and ceilings inside the building'],
        ];

        foreach ($types as $type) {
            MaintenanceChecklistType::create($type);
        }
    }
}
