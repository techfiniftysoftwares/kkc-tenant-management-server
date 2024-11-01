<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\MaintenanceChecklistType;

class MaintenanceChecklistTypeSeeder extends Seeder
{
    public function run()
    {
        $types = [
            ['name' => 'HVAC', 'description' => 'Heating, Ventilation, and Air Conditioning checks'],
            ['name' => 'Plumbing', 'description' => 'Plumbing system checks'],
            ['name' => 'Electrical', 'description' => 'Electrical system checks'],
            ['name' => 'Fire Protection', 'description' => 'Fire protection system checks'],
            ['name' => 'Building Exterior', 'description' => 'Building exterior checks'],
            ['name' => 'Interior Finishes', 'description' => 'Interior finishes checks'],
            ['name' => 'Elevator', 'description' => 'Elevator system checks'],
            ['name' => 'General', 'description' => 'General maintenance checks'],
        ];

        foreach ($types as $type) {
            MaintenanceChecklistType::create($type);
        }
    }
}
