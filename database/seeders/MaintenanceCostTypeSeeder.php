<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MaintenanceCostTypeSeeder extends Seeder
{
    public function run()
    {
        $costTypes = [
            [
                'name' => 'Labor',
                'description' => 'Costs associated with the workforce performing the maintenance tasks.',
            ],
            [
                'name' => 'Materials',
                'description' => 'Costs of parts, components, and consumables used in maintenance activities.',
            ],
            [
                'name' => 'Equipment Rental',
                'description' => 'Costs for renting specialized tools or equipment needed for maintenance.',
            ],
            [
                'name' => 'Contractor Services',
                'description' => 'Costs for hiring external contractors or specialists for maintenance tasks.',
            ],
            [
                'name' => 'Disposal',
                'description' => 'Costs associated with proper disposal of old parts or hazardous materials.',
            ],
            [
                'name' => 'Diagnostics',
                'description' => 'Costs related to testing, inspecting, and diagnosing issues.',
            ],
            [
                'name' => 'Training',
                'description' => 'Costs for training staff on new maintenance procedures or equipment.',
            ],
            [
                'name' => 'Documentation',
                'description' => 'Costs associated with creating and maintaining maintenance records and reports.',
            ],
            [
                'name' => 'Transportation',
                'description' => 'Costs for transporting personnel, equipment, or materials to and from maintenance sites.',
            ],
            [
                'name' => 'Software/Licenses',
                'description' => 'Costs for maintenance management software or specialized diagnostic tool licenses.',
            ],
        ];

        foreach ($costTypes as $type) {
            DB::table('maintenance_cost_types')->insert([
                'name' => $type['name'],
                'description' => $type['description'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
