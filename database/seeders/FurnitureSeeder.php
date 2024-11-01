<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class FurnitureSeeder extends Seeder
{
    public function run()
    {
        $assetTypeId = DB::table('asset_types')->where('name', 'Furniture')->first()->id ?? null;
        if (!$assetTypeId) {
            throw new \Exception('Furniture asset type not found. Please ensure it exists in the asset_types table.');
        }

        $facilityId = 1; // As per your previous data
        $branchId = 1; // As per your previous data
        $buildingId = 1; // As per your previous data

        $furnitureTypes = ['Desk', 'Chair', 'Bookshelf', 'Filing Cabinet', 'Conference Table'];
        $materials = ['Wood', 'Metal', 'Plastic', 'Glass', 'Composite'];
        $colors = ['Black', 'White', 'Brown', 'Gray', 'Blue'];
        $finishes = ['Polished', 'Matte', 'Satin', 'Glossy', 'Textured'];
        $upholsteryMaterials = ['Leather', 'Fabric', 'Vinyl', null];
        $upholsteryColors = ['Black', 'Gray', 'Blue', 'Red', null];
        $manufacturers = ['OfficePro', 'ErgoComfort', 'ModernWorks', 'ClassicFurnish', 'TechSpace'];

        for ($i = 1; $i <= 5; $i++) {
            $floorId = DB::table('floors')->inRandomOrder()->first()->id ?? null;

            // Randomly choose between room and common area
            if (rand(0, 1) == 0) {
                $roomId = DB::table('rooms')->inRandomOrder()->first()->id ?? null;
                $commonAreaId = null;
                $location = "Room";
            } else {
                $roomId = null;
                $commonAreaId = DB::table('common_areas')->inRandomOrder()->first()->id ?? null;
                $location = "Common Area";
            }

            $furnitureType = $furnitureTypes[$i - 1]; // Ensure we get one of each type
            $material = $materials[array_rand($materials)];
            $color = $colors[array_rand($colors)];
            $finish = $finishes[array_rand($finishes)];
            $manufacturer = $manufacturers[array_rand($manufacturers)];

            $acquisitionDate = Carbon::now()->subDays(rand(0, 730)); // Within last 2 years
            $warrantyYears = rand(1, 5);
            $warrantyStartDate = $acquisitionDate;
            $warrantyEndDate = $acquisitionDate->copy()->addYears($warrantyYears);

            $referenceNumber = $this->generateReferenceNumber($furnitureType, $i);

            // Create the asset first
            $assetId = DB::table('assets')->insertGetId([
                'asset_type_id' => $assetTypeId,
                'reference_number' => $referenceNumber,
                'name' => "{$color} {$material} {$furnitureType}",
                'description' => "A {$color} {$furnitureType} made of {$material} with {$finish} finish, located in {$location}",
                'facility_id' => $facilityId,
                'branch_id' => $branchId,
                'building_id' => $buildingId,
                'floor_id' => $floorId,
                'room_id' => $roomId,
                'common_area_id' => $commonAreaId,
                'acquisition_date' => $acquisitionDate,
                'supplier_id' => DB::table('suppliers')->inRandomOrder()->first()->id ?? null,
                'warranty_start_date' => $warrantyStartDate,
                'warranty_end_date' => $warrantyEndDate,
                'condition' => ['Excellent', 'Good', 'Fair', 'Poor'][rand(0, 3)],
                'maintenance_schedule' => $this->generateMaintenanceSchedule($furnitureType),
                'owner' => 'Facility Management Department',
                'barcode' => $this->generateBarcode($referenceNumber),
                'serial_number' => $this->generateSerialNumber($manufacturer),
                'manufacturer' => $manufacturer,
                'model_number' => $this->generateModelNumber($furnitureType, $material),
                'status' => ['Active', 'Inactive', 'Under Maintenance'][rand(0, 2)],
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            $upholsteryMaterial = $upholsteryMaterials[array_rand($upholsteryMaterials)];
            $upholsteryColor = $upholsteryMaterial ? $upholsteryColors[array_rand($upholsteryColors)] : null;

            // Now create the furniture
            DB::table('furniture')->insert([
                'asset_id' => $assetId,
                'furniture_type' => $furnitureType,
                'material' => $material,
                'dimensions' => $this->generateDimensions($furnitureType),
                'quantity' => rand(1, 10),
                'finish' => $finish,
                'color' => $color,
                'upholstery_material' => $upholsteryMaterial,
                'upholstery_color' => $upholsteryColor,
                'fire_retardant_treated' => (bool)rand(0, 1),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }

    private function generateReferenceNumber($furnitureType, $number)
    {
        $prefix = 'FUR-' . substr($furnitureType, 0, 2);
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

    private function generateModelNumber($furnitureType, $material)
    {
        return strtoupper(substr($furnitureType, 0, 2) . substr($material, 0, 2)) . '-' . rand(1000, 9999);
    }

    private function generateMaintenanceSchedule($furnitureType)
    {
        $schedules = [
            "Yearly: General inspection and tightening of screws",
            "Half-yearly: Cleaning and polishing",
            "Monthly: Check for damages and report",
            "Quarterly: Lubricate moving parts (if applicable)",
        ];
        return $schedules[array_rand($schedules)];
    }

    private function generateDimensions($furnitureType)
    {
        switch ($furnitureType) {
            case 'Desk':
                return rand(120, 180) . 'x' . rand(60, 80) . 'x' . rand(70, 80) . ' cm';
            case 'Chair':
                return rand(50, 70) . 'x' . rand(50, 70) . 'x' . rand(80, 120) . ' cm';
            case 'Bookshelf':
                return rand(80, 120) . 'x' . rand(30, 50) . 'x' . rand(180, 220) . ' cm';
            case 'Filing Cabinet':
                return rand(40, 60) . 'x' . rand(50, 70) . 'x' . rand(100, 150) . ' cm';
            case 'Conference Table':
                return rand(180, 300) . 'x' . rand(90, 120) . 'x' . rand(70, 80) . ' cm';
            default:
                return '';
        }
    }
}
