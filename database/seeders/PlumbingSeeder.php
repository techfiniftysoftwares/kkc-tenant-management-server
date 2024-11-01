<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class PlumbingSeeder extends Seeder
{
    public function run()
    {
        $assetTypeId = DB::table('asset_types')->where('name', 'Plumbing')->first()->id ?? null;
        if (!$assetTypeId) {
            throw new \Exception('Plumbing asset type not found. Please ensure it exists in the asset_types table.');
        }

        $facilityId = 1;
        $branchId = 1;
        $buildingId = 1;

        $plumbingTypes = ['Sink', 'Toilet', 'Shower', 'Bathtub', 'Water Heater'];
        $materials = ['Porcelain', 'Stainless Steel', 'Ceramic', 'Acrylic', 'Cast Iron'];
        $finishes = ['Polished', 'Brushed', 'Matte', 'Glossy', 'Textured'];
        $colors = ['White', 'Chrome', 'Brushed Nickel', 'Oil-Rubbed Bronze', 'Matte Black'];
        $manufacturers = ['AquaPro', 'PlumbMaster', 'HydroTech', 'FlowSystems', 'WaterWorks'];

        for ($i = 1; $i <= 5; $i++) {
            $floorId = DB::table('floors')->inRandomOrder()->first()->id ?? null;
            $roomId = DB::table('rooms')->inRandomOrder()->first()->id ?? null;

            $plumbingType = $plumbingTypes[$i - 1]; // Ensure we get one of each type
            $material = $materials[array_rand($materials)];
            $finish = $finishes[array_rand($finishes)];
            $color = $colors[array_rand($colors)];
            $manufacturer = $manufacturers[array_rand($manufacturers)];

            $installationDate = Carbon::now()->subDays(rand(0, 1825)); // Within last 5 years
            $acquisitionDate = $installationDate->copy()->subDays(rand(7, 30)); // Acquisition a bit before installation
            $warrantyYears = rand(1, 10);
            $warrantyStartDate = $installationDate;
            $warrantyEndDate = $installationDate->copy()->addYears($warrantyYears);

            $referenceNumber = $this->generateReferenceNumber($plumbingType, $i);

            // Create the asset first
            $assetId = DB::table('assets')->insertGetId([
                'asset_type_id' => $assetTypeId,
                'reference_number' => $referenceNumber,
                'name' => "{$color} {$material} {$plumbingType}",
                'description' => "A {$color} {$plumbingType} made of {$material} with {$finish} finish",
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
                'maintenance_schedule' => $this->generateMaintenanceSchedule($plumbingType),
                'owner' => 'Facility Management Department',
                'barcode' => $this->generateBarcode($referenceNumber),
                'serial_number' => $this->generateSerialNumber($manufacturer),
                'manufacturer' => $manufacturer,
                'model_number' => $this->generateModelNumber($plumbingType, $material),
                'status' => ['Active', 'Inactive', 'Under Maintenance'][rand(0, 2)],
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            // Now create the plumbing
            DB::table('plumbings')->insert([
                'asset_id' => $assetId,
                'plumbing_type' => $plumbingType,
                'material' => $material,
                'finish' => $finish,
                'color' => $color,
                'flow_rate' => $this->generateFlowRate($plumbingType),
                'water_consumption' => $this->generateWaterConsumption($plumbingType),
                'drain_size' => $this->generateDrainSize($plumbingType),
                'trap_type' => $this->generateTrapType($plumbingType),
                'supply_line_size' => $this->generateSupplyLineSize(),
                'supply_valve_type' => $this->generateSupplyValveType(),
                'water_pressure_requirement' => rand(20, 80) . ' PSI',
                'installation_date' => $installationDate,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }

    private function generateReferenceNumber($plumbingType, $number)
    {
        $prefix = 'PLM-' . substr($plumbingType, 0, 2);
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

    private function generateModelNumber($plumbingType, $material)
    {
        return strtoupper(substr($plumbingType, 0, 2) . substr($material, 0, 2)) . '-' . rand(1000, 9999);
    }

    private function generateMaintenanceSchedule($plumbingType)
    {
        $schedules = [
            "Monthly: Check for leaks and proper operation",
            "Quarterly: Clean and descale",
            "Yearly: Inspect and replace worn parts",
            "Bi-annually: Pressure test and adjust",
        ];
        return $schedules[array_rand($schedules)];
    }

    private function generateFlowRate($plumbingType)
    {
        switch ($plumbingType) {
            case 'Sink':
                return rand(15, 25) . ' L/min';
            case 'Toilet':
                return rand(40, 60) . ' L/min';
            case 'Shower':
                return rand(15, 30) . ' L/min';
            case 'Bathtub':
                return rand(30, 50) . ' L/min';
            case 'Water Heater':
                return rand(20, 40) . ' L/min';
            default:
                return '';
        }
    }

    private function generateWaterConsumption($plumbingType)
    {
        switch ($plumbingType) {
            case 'Sink':
                return rand(5, 15) . ' L/use';
            case 'Toilet':
                return rand(3, 6) . ' L/flush';
            case 'Shower':
                return rand(6, 10) . ' L/min';
            case 'Bathtub':
                return rand(150, 300) . ' L/bath';
            case 'Water Heater':
                return rand(150, 300) . ' L/hour';
            default:
                return '';
        }
    }

    private function generateDrainSize($plumbingType)
    {
        switch ($plumbingType) {
            case 'Sink':
            case 'Shower':
                return ['1.25 inch', '1.5 inch', '2 inch'][rand(0, 2)];
            case 'Toilet':
                return '3 inch';
            case 'Bathtub':
                return '1.5 inch';
            default:
                return '';
        }
    }

    private function generateTrapType($plumbingType)
    {
        $types = ['P-trap', 'S-trap', 'Bottle trap', 'Drum trap'];
        return in_array($plumbingType, ['Sink', 'Shower', 'Bathtub']) ? $types[array_rand($types)] : 'N/A';
    }

    private function generateSupplyLineSize()
    {
        return ['3/8 inch', '1/2 inch', '3/4 inch'][rand(0, 2)];
    }

    private function generateSupplyValveType()
    {
        $types = ['Ball valve', 'Gate valve', 'Globe valve', 'Angle valve', 'Check valve'];
        return $types[array_rand($types)];
    }
}
