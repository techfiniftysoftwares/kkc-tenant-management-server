<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class UserGroupSeeder extends Seeder
{
    public function run()
    {
        $now = Carbon::now();
        $userGroups = [
            ['name' => 'Administrators', 'description' => 'Full access to all features and functionalities of the facility management system.', 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'Managers/Supervisors', 'description' => 'Responsible for overseeing specific departments, areas, or teams within the facility.', 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'Technicians/Maintenance Crew', 'description' => 'Responsible for performing maintenance tasks, repairs, inspections, and operational activities.', 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'Front Desk/Receptionists', 'description' => 'Handle visitor management, access control, and communication with occupants or tenants.', 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'Security Personnel', 'description' => 'Monitor security cameras, patrol premises, and respond to security incidents.', 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'Cleaning Crew', 'description' => 'Maintain cleanliness and hygiene within the facility, including janitorial services and waste management.', 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'Tenant/Occupant', 'description' => 'Limited access to submit maintenance requests, view facility information, or access shared resources.', 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'Contractors/Vendors', 'description' => 'External contractors or vendors with temporary access for specific tasks or projects.', 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'Executive Leadership', 'description' => 'Access high-level information, reports, and analytics for strategic decision-making.', 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'Auditors/Compliance', 'description' => 'Conduct audits, inspections, and ensure regulatory compliance within the facility.', 'created_at' => $now, 'updated_at' => $now]
        ];
        DB::table('user_groups')->insert($userGroups);
    }
}
