<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Asset;
use App\Models\MaintenanceType;
use App\Models\User;
use App\Models\Maintenance;
use App\Models\MaintenanceChecklistType;
use App\Models\MaintenanceChecklistItem;
use App\Models\MaintenanceChecklist;
use App\Models\MaintenanceCost;
use App\Models\MaintenanceLog;
use Carbon\Carbon;
use Faker\Factory as Faker;

class ComprehensiveMaintenanceSeeder extends Seeder
{
    protected $faker;

    public function __construct()
    {
        $this->faker = Faker::create();
    }

    public function run()
    {
        $assets = Asset::all();
        $maintenanceTypes = MaintenanceType::all();
        $users = User::all();

        $startDate = Carbon::create(2024, 5, 1);
        $endDate = Carbon::create(2024, 7, 31);

        for ($i = 0; $i < 20; $i++) {
            $asset = $assets->random();
            $maintenanceType = $maintenanceTypes->random();
            $assignedUser = $users->random();

            // Ensure the start date is not in the future
            $safeStartDate = min($startDate, Carbon::now());

            $scheduledDate = $this->faker->dateTimeBetween($safeStartDate, $endDate);

            $maintenance = Maintenance::create([
                'asset_id' => $asset->id,
                'facility_id' => $asset->facility_id,
                'branch_id' => $asset->branch_id,
                'building_id' => $asset->building_id,
                'floor_id' => $asset->floor_id,
                'room_id' => $asset->room_id,
                'common_area_id' => $asset->common_area_id,
                'corridor_id' => $asset->corridor_id,
                'stairs_id' => $asset->stairs_id,
                'maintenance_type_id' => $maintenanceType->id,
                'title' => $this->generateMaintenanceTitle($asset, $maintenanceType),
                'description' => $this->generateMaintenanceDescription($asset, $maintenanceType),
                'scheduled_date' => $scheduledDate,
                'start_date' => $maintenanceType->name == 'Reactive Maintenance' ? $scheduledDate : null,
                'end_date' => $maintenanceType->name == 'Reactive Maintenance' ? Carbon::parse($scheduledDate)->addHours(rand(1, 8)) : null,
                'status' => $this->getMaintenanceStatus($scheduledDate),
                'assigned_to' => $assignedUser->id,
                'notes' => $this->generateMaintenanceNotes($maintenanceType),
            ]);

            // Create Maintenance Checklists
            $this->createMaintenanceChecklists($maintenance, $asset);

            // Create Maintenance Costs
            $this->createMaintenanceCosts($maintenance);

            // Create Maintenance Logs
            $this->createMaintenanceLogs($maintenance, $users);
        }
    }

    private function generateMaintenanceTitle($asset, $maintenanceType)
    {
        $action = $maintenanceType->name == 'Reactive Maintenance' ? 'Repair' : 'Maintenance';
        return "{$maintenanceType->name} - {$action} for {$asset->name}";
    }

    private function generateMaintenanceDescription($asset, $maintenanceType)
    {
        $descriptions = [
            'Predictive Maintenance' => "Perform predictive analysis and maintenance on {$asset->name} based on performance data.",
            'Preventive Maintenance' => "Conduct scheduled preventive maintenance on {$asset->name} to ensure optimal performance.",
            'Reactive Maintenance' => "Address reported issues and perform necessary repairs on {$asset->name}.",
        ];
        return $descriptions[$maintenanceType->name] ?? "Perform maintenance on {$asset->name}.";
    }

    private function getMaintenanceStatus($scheduledDate)
    {
        $now = Carbon::now();
        $scheduledDate = Carbon::parse($scheduledDate);

        if ($scheduledDate->isFuture()) {
            return 'Scheduled';
        } elseif ($scheduledDate->isToday()) {
            return $this->faker->randomElement(['In Progress', 'Scheduled']);
        } else {
            return $this->faker->randomElement(['Completed', 'Overdue']);
        }
    }

    private function generateMaintenanceNotes($maintenanceType)
    {
        $notes = [
            'Predictive Maintenance' => "Based on recent performance data, this maintenance is crucial to prevent potential failures.",
            'Preventive Maintenance' => "Regular maintenance to keep the asset in optimal condition and prevent unexpected breakdowns.",
            'Reactive Maintenance' => "Responding to reported issues. Quick action required to minimize downtime.",
        ];
        return $notes[$maintenanceType->name] ?? "Standard maintenance procedure to be followed.";
    }

    private function createMaintenanceChecklists($maintenance, $asset)
    {
        $checklistType = $this->getRelevantChecklistType($asset);
        $checklistItems = MaintenanceChecklistItem::where('maintenance_checklist_type_id', $checklistType->id)->get();

        foreach ($checklistItems as $item) {
            MaintenanceChecklist::create([
                'maintenance_id' => $maintenance->id,
                'maintenance_checklist_type_id' => $checklistType->id,
                'maintenance_checklist_item_id' => $item->id,
                'completed' => $maintenance->status == 'Completed' ? $this->faker->boolean(80) : false,
                'notes' => $maintenance->status == 'Completed' ? $this->faker->sentence : null,
            ]);
        }
    }

    private function getRelevantChecklistType($asset)
    {
        $assetName = strtolower($asset->name);
        if (strpos($assetName, 'hvac') !== false) {
            return MaintenanceChecklistType::where('name', 'HVAC')->first();
        } elseif (strpos($assetName, 'plumbing') !== false) {
            return MaintenanceChecklistType::where('name', 'Plumbing')->first();
        } elseif (strpos($assetName, 'electrical') !== false) {
            return MaintenanceChecklistType::where('name', 'Electrical')->first();
        } elseif (strpos($assetName, 'fire') !== false) {
            return MaintenanceChecklistType::where('name', 'Fire Protection')->first();
        } elseif (strpos($assetName, 'elevator') !== false) {
            return MaintenanceChecklistType::where('name', 'Elevator')->first();
        } else {
            return MaintenanceChecklistType::where('name', 'General')->first();
        }
    }

    private function createMaintenanceCosts($maintenance)
    {
        $costTypes = ['Labor', 'Materials', 'Equipment Rental', 'Contractor Services'];
        $numberOfCosts = rand(1, 3);
        for ($j = 0; $j < $numberOfCosts; $j++) {
            MaintenanceCost::create([
                'maintenance_id' => $maintenance->id,
                'cost_type' => $this->faker->randomElement($costTypes),
                'amount' => $this->faker->randomFloat(2, 50, 1000),
                'description' => $this->faker->sentence,
            ]);
        }
    }

    private function createMaintenanceLogs($maintenance, $users)
    {
        $numberOfLogs = rand(1, 5);
        $startDate = $maintenance->start_date ?? $maintenance->scheduled_date;

        for ($k = 0; $k < $numberOfLogs; $k++) {
            $logDate = $this->faker->dateTimeBetween($startDate, $maintenance->end_date ?? 'now');
            MaintenanceLog::create([
                'maintenance_id' => $maintenance->id,
                'user_id' => $users->random()->id,
                'log_entry' => $this->generateLogEntry($maintenance, $k),
                'created_at' => $logDate,
                'updated_at' => $logDate,
            ]);
        }
    }

    private function generateLogEntry($maintenance, $index)
    {
        $entries = [
            "Initiated maintenance process for {$maintenance->asset->name}.",
            "Conducted initial inspection of {$maintenance->asset->name}.",
            "Identified issue with {$maintenance->asset->name}: {$this->faker->sentence}.",
            "Performed maintenance tasks as per checklist.",
            "Completed maintenance. Asset returned to service.",
        ];
        return $entries[$index] ?? $this->faker->sentence;
    }
}
