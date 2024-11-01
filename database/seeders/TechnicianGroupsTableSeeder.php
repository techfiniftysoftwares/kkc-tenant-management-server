<?php

namespace Database\Seeders;

use App\Models\TechnicianGroup;
use Illuminate\Database\Seeder;

class TechnicianGroupsTableSeeder extends Seeder
{
    public function run()
    {
        $groups = [
            'Electrical Team',
            'Mechanical Team',
            'Plumbing Team',
            'HVAC Team',
            'Carpentry Team',
            'Painting Team',
            'Landscaping Team',
            'Roofing Team',
            'Welding Team',
            'General Maintenance Team',
        ];

        foreach ($groups as $group) {
            TechnicianGroup::create(['name' => $group]);
        }
    }
}