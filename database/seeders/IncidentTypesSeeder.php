<?php
namespace Database\Seeders;
use Illuminate\Database\Seeder;
use App\Models\IncidentType;

class IncidentTypesSeeder extends Seeder
{
    public function run()
    {
        $incidentTypes = [
            
            [
                'name' => 'Fire',
                'priority' => 'Critical',
                'turnaround_time' => 'Immediate',
            ],
            [
                'name' => 'Medical Emergency',
                'priority' => 'Critical',
                'turnaround_time' => 'Immediate',
            ],
            [
                'name' => 'Security Breach',
                'priority' => 'High',
                'turnaround_time' => '1 hour',
            ],
            [
                'name' => 'Chemical Spill',
                'priority' => 'High',
                'turnaround_time' => '1 hour',
            ],
            [
                'name' => 'Power Outage',
                'priority' => 'Medium',
                'turnaround_time' => '2 hours',
            ],
            [
                'name' => 'Gas Leak',
                'priority' => 'High',
                'turnaround_time' => '1 hour',
            ],
            [
                'name' => 'Water Leakage',
                'priority' => 'Medium',
                'turnaround_time' => '2 hours',
            ],
            [
                'name' => 'Structural Damage',
                'priority' => 'High',
                'turnaround_time' => '1 hour',
            ],
            [
                'name' => 'Equipment Failure',
                'priority' => 'Medium',
                'turnaround_time' => '2 hours',
            ],
            [
                'name' => 'Suspicious Activity',
                'priority' => 'Medium',
                'turnaround_time' => '2 hours',
            ],
            [
                'name' => 'Vandalism',
                'priority' => 'Medium',
                'turnaround_time' => '2 hours',
            ],
            [
                'name' => 'Gasoline Spill',
                'priority' => 'High',
                'turnaround_time' => '1 hour',
            ],
            [
                'name' => 'Natural Disaster',
                'priority' => 'High',
                'turnaround_time' => '1 hour',
            ],
            [
                'name' => 'Flood',
                'priority' => 'High',
                'turnaround_time' => '1 hour',
            ],
            [
                'name' => 'Robbery',
                'priority' => 'High',
                'turnaround_time' => '1 hour',
            ],
            [
                'name' => 'Assault',
                'priority' => 'High',
                'turnaround_time' => '1 hour',
            ],
            [
                'name' => 'Explosion',
                'priority' => 'High',
                'turnaround_time' => '1 hour',
            ],
            [
                'name' => 'Electrical Failure',
                'priority' => 'Medium',
                'turnaround_time' => '2 hours',
            ],
        ];

        foreach ($incidentTypes as $type) {
            IncidentType::create($type);
        }
    }
}
