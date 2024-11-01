<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class FireProtectionSeeder extends Seeder
{
    public function run()
    {
        $assetTypeId = DB::table('asset_types')->where('name', 'Fire Safety')->first()->id ?? null;
        if (!$assetTypeId) {
            throw new \Exception('Fire Protection asset type not found. Please ensure it exists in the asset_types table.');
        }

        $facilityId = 1; // As per your previous data
        $branchId = 1; // As per your previous data
        $buildingId = 1; // As per your previous data

        $fireProtectionTypes = ['Smoke Detector', 'Sprinkler System', 'Fire Alarm Panel', 'Standpipe System', 'Fire Pump'];
        $manufacturers = ['Kidde', 'Simplex', 'Tyco', 'Notifier', 'Honeywell'];

        for ($i = 1; $i <= 5; $i++) {
            $floorId = DB::table('floors')->inRandomOrder()->first()->id ?? null;
            $roomId = DB::table('rooms')->inRandomOrder()->first()->id ?? null;

            $fireProtectionType = $fireProtectionTypes[$i - 1]; // Ensure we get one of each type
            $manufacturer = $manufacturers[array_rand($manufacturers)];

            $installationDate = Carbon::now()->subDays(rand(0, 3650)); // Within last 10 years
            $acquisitionDate = $installationDate->copy()->subDays(rand(7, 30)); // Acquisition a bit before installation
            $warrantyYears = rand(5, 15);
            $warrantyStartDate = $installationDate;
            $warrantyEndDate = $installationDate->copy()->addYears($warrantyYears);

            $referenceNumber = $this->generateReferenceNumber($fireProtectionType, $i);

            // Create the asset first
            $assetId = DB::table('assets')->insertGetId([
                'asset_type_id' => $assetTypeId,
                'reference_number' => $referenceNumber,
                'name' => "{$manufacturer} {$fireProtectionType}",
                'description' => "A {$fireProtectionType} fire protection system manufactured by {$manufacturer}",
                'facility_id' => $facilityId,
                'branch_id' => $branchId,
                'building_id' => $buildingId,
                'floor_id' => $floorId,
                'room_id' => $roomId,
                'acquisition_date' => $acquisitionDate,
                'supplier_id' => DB::table('suppliers')->inRandomOrder()->first()->id ?? null,
                'warranty_start_date' => $warrantyStartDate,
                'warranty_end_date' => $warrantyEndDate,
                'condition' => ['Excellent', 'Good', 'Fair', 'Poor'][rand(0, 3)],
                'maintenance_schedule' => $this->generateMaintenanceSchedule($fireProtectionType),
                'owner' => 'Facility Management Department',
                'barcode' => $this->generateBarcode($referenceNumber),
                'serial_number' => $this->generateSerialNumber($manufacturer),
                'manufacturer' => $manufacturer,
                'model_number' => $this->generateModelNumber($fireProtectionType),
                'status' => ['Active', 'Inactive', 'Under Maintenance'][rand(0, 2)],
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            // Now create the fire protection
            DB::table('fire_protections')->insert([
                'asset_id' => $assetId,
                'fire_protection_type' => $fireProtectionType,
                'coverage_area' => $this->generateCoverageArea($fireProtectionType),
                'sensor_type' => $this->generateSensorType($fireProtectionType),
                'sensor_spacing' => $this->generateSensorSpacing($fireProtectionType),
                'alarm_type' => $this->generateAlarmType(),
                'alarm_decibels' => $this->generateAlarmDecibels(),
                'sprinkler_type' => $this->generateSprinklerType($fireProtectionType),
                'sprinkler_temperature_rating' => $this->generateSprinklerTemperatureRating($fireProtectionType),
                'sprinkler_flow_rate' => $this->generateSprinklerFlowRate($fireProtectionType),
                'standpipe_material' => $this->generateStandpipeMaterial($fireProtectionType),
                'standpipe_size' => $this->generateStandpipeSize($fireProtectionType),
                'fire_pump_type' => $this->generateFirePumpType($fireProtectionType),
                'fire_pump_capacity' => $this->generateFirePumpCapacity($fireProtectionType),
                'installation_date' => $installationDate,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }

    private function generateReferenceNumber($fireProtectionType, $number)
    {
        $prefix = 'FP-' . substr(str_replace(' ', '', $fireProtectionType), 0, 2);
        return strtoupper($prefix) . '-' . str_pad($number, 4, '0', STR_PAD_LEFT);
    }

    private function generateBarcode($referenceNumber)
    {
        return 'BAR' . strtoupper(substr(md5($referenceNumber), 0, 10));
    }

    private function generateSerialNumber($manufacturer)
    {
        return strtoupper(substr($manufacturer, 0, 3)) . '-' . rand(100000, 999999);
    }

    private function generateModelNumber($fireProtectionType)
    {
        return strtoupper(substr(str_replace(' ', '', $fireProtectionType), 0, 4)) . '-' . rand(1000, 9999);
    }

    private function generateMaintenanceSchedule($fireProtectionType)
    {
        $schedules = [
            "Monthly: Visual inspection",
            "Quarterly: Functional testing",
            "Bi-annually: Professional inspection and maintenance",
            "Yearly: Comprehensive system test",
        ];
        return $schedules[array_rand($schedules)];
    }

    private function generateCoverageArea($fireProtectionType)
    {
        return rand(50, 500) . ' sq ft';
    }

    private function generateSensorType($fireProtectionType)
    {
        return $fireProtectionType == 'Smoke Detector' ? ['Photoelectric', 'Ionization', 'Dual-sensor'][rand(0, 2)] : 'N/A';
    }

    private function generateSensorSpacing($fireProtectionType)
    {
        return $fireProtectionType == 'Smoke Detector' ? rand(20, 50) . ' ft' : 'N/A';
    }

    private function generateAlarmType()
    {
        return ['Horn', 'Strobe', 'Horn/Strobe', 'Voice Evacuation'][rand(0, 3)];
    }

    private function generateAlarmDecibels()
    {
        return rand(75, 110) . ' dB';
    }

    private function generateSprinklerType($fireProtectionType)
    {
        return $fireProtectionType == 'Sprinkler System' ? ['Wet Pipe', 'Dry Pipe', 'Pre-Action', 'Deluge'][rand(0, 3)] : null;
    }

    private function generateSprinklerTemperatureRating($fireProtectionType)
    {
        return $fireProtectionType == 'Sprinkler System' ? [135, 155, 175, 200, 286, 360][rand(0, 5)] . '°F' : null;
    }

    private function generateSprinklerFlowRate($fireProtectionType)
    {
        return $fireProtectionType == 'Sprinkler System' ? rand(10, 40) . ' GPM' : null;
    }

    private function generateStandpipeMaterial($fireProtectionType)
    {
        return $fireProtectionType == 'Standpipe System' ? ['Galvanized Steel', 'Stainless Steel', 'Ductile Iron'][rand(0, 2)] : null;
    }

    private function generateStandpipeSize($fireProtectionType)
    {
        return $fireProtectionType == 'Standpipe System' ? [2.5, 4, 6][rand(0, 2)] . ' inches' : null;
    }

    private function generateFirePumpType($fireProtectionType)
    {
        return $fireProtectionType == 'Fire Pump' ? ['Electric', 'Diesel', 'Jockey'][rand(0, 2)] : null;
    }

    private function generateFirePumpCapacity($fireProtectionType)
    {
        return $fireProtectionType == 'Fire Pump' ? rand(500, 2500) . ' GPM' : null;
    }
}
