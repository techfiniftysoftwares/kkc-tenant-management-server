<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class LightingSeeder extends Seeder
{
    public function run()
    {
        $assetTypeId = DB::table('asset_types')->where('name', 'Lighting')->first()->id ?? null;
        if (!$assetTypeId) {
            throw new \Exception('Electricals asset type not found. Please ensure it exists in the asset_types table.');
        }

        $facilityId = 1; // As per your previous data
        $branchId = 1; // As per your previous data
        $buildingId = 1; // As per your previous data

        $lightingTypes = ['Ceiling Light', 'Wall Sconce', 'Floor Lamp', 'Table Lamp', 'Pendant Light'];
        $materials = ['Metal', 'Glass', 'Plastic', 'Wood', 'Fabric'];
        $finishes = ['Brushed Nickel', 'Polished Chrome', 'Matte Black', 'Antique Brass', 'Satin White'];
        $colors = ['White', 'Black', 'Silver', 'Bronze', 'Gold'];
        $lampTypes = ['LED', 'Fluorescent', 'Incandescent', 'Halogen', 'CFL'];
        $manufacturers = ['LightCraft', 'IlluminaTech', 'BrightWave', 'LumenPro', 'GlowMaster'];

        for ($i = 1; $i <= 5; $i++) {
            $floorId = DB::table('floors')->inRandomOrder()->first()->id ?? null;

            // Randomly choose between room, common area, and corridor
            $location = rand(0, 2);
            if ($location == 0) {
                $roomId = DB::table('rooms')->inRandomOrder()->first()->id ?? null;
                $commonAreaId = null;
                $corridorId = null;
                $locationDesc = "Room";
            } elseif ($location == 1) {
                $roomId = null;
                $commonAreaId = DB::table('common_areas')->inRandomOrder()->first()->id ?? null;
                $corridorId = null;
                $locationDesc = "Common Area";
            } else {
                $roomId = null;
                $commonAreaId = null;
                $corridorId = DB::table('corridors')->inRandomOrder()->first()->id ?? null;
                $locationDesc = "Corridor";
            }

            $lightingType = $lightingTypes[$i - 1]; // Ensure we get one of each type
            $material = $materials[array_rand($materials)];
            $finish = $finishes[array_rand($finishes)];
            $color = $colors[array_rand($colors)];
            $lampType = $lampTypes[array_rand($lampTypes)];
            $manufacturer = $manufacturers[array_rand($manufacturers)];

            $acquisitionDate = Carbon::now()->subDays(rand(0, 730)); // Within last 2 years
            $warrantyYears = rand(1, 5);
            $warrantyStartDate = $acquisitionDate;
            $warrantyEndDate = $acquisitionDate->copy()->addYears($warrantyYears);

            $referenceNumber = $this->generateReferenceNumber($lightingType, $i);

            // Create the asset first
            $assetId = DB::table('assets')->insertGetId([
                'asset_type_id' => $assetTypeId,
                'reference_number' => $referenceNumber,
                'name' => "{$color} {$lightingType}",
                'description' => "A {$color} {$lightingType} made of {$material} with {$finish} finish, using {$lampType} lamp, located in {$locationDesc}",
                'facility_id' => $facilityId,
                'branch_id' => $branchId,
                'building_id' => $buildingId,
                'floor_id' => $floorId,
                'room_id' => $roomId,
                'common_area_id' => $commonAreaId,
                'corridor_id' => $corridorId,
                'acquisition_date' => $acquisitionDate,
                'supplier_id' => DB::table('suppliers')->inRandomOrder()->first()->id ?? null,
                'warranty_start_date' => $warrantyStartDate,
                'warranty_end_date' => $warrantyEndDate,
                'condition' => ['Excellent', 'Good', 'Fair', 'Poor'][rand(0, 3)],
                'maintenance_schedule' => $this->generateMaintenanceSchedule(),
                'owner' => 'Facility Management Department',
                'barcode' => $this->generateBarcode($referenceNumber),
                'serial_number' => $this->generateSerialNumber($manufacturer),
                'manufacturer' => $manufacturer,
                'model_number' => $this->generateModelNumber($lightingType, $lampType),
                'status' => ['Active', 'Inactive', 'Under Maintenance'][rand(0, 2)],
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            // Now create the lighting
            DB::table('lightings')->insert([
                'asset_id' => $assetId,
                'lighting_type' => $lightingType,
                'material' => $material,
                'dimensions' => $this->generateDimensions($lightingType),
                'finish' => $finish,
                'color' => $color,
                'lamp_type' => $lampType,
                'lamp_wattage' => $this->generateWattage($lampType),
                'lamp_color' => $this->generateLampColor(),
                'ballast_type' => $lampType == 'Fluorescent' ? ['Electronic', 'Magnetic'][rand(0, 1)] : null,
                'voltage_requirement' => ['120V', '240V', '12V'][rand(0, 2)],
                'energy_star_rated' => (bool)rand(0, 1),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }

    private function generateReferenceNumber($lightingType, $number)
    {
        $prefix = 'LGT-' . substr($lightingType, 0, 2);
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

    private function generateModelNumber($lightingType, $lampType)
    {
        return strtoupper(substr($lightingType, 0, 2) . substr($lampType, 0, 2)) . '-' . rand(1000, 9999);
    }

    private function generateMaintenanceSchedule()
    {
        $schedules = [
            "Monthly: Dust and clean fixture",
            "Quarterly: Check and replace bulbs if needed",
            "Yearly: Inspect wiring and connections",
            "Bi-annually: Test emergency lighting function",
        ];
        return $schedules[array_rand($schedules)];
    }

    private function generateDimensions($lightingType)
    {
        switch ($lightingType) {
            case 'Ceiling Light':
                return rand(30, 60) . 'x' . rand(30, 60) . 'x' . rand(10, 20) . ' cm';
            case 'Wall Sconce':
                return rand(20, 40) . 'x' . rand(15, 30) . 'x' . rand(10, 20) . ' cm';
            case 'Floor Lamp':
                return rand(30, 50) . 'x' . rand(30, 50) . 'x' . rand(120, 180) . ' cm';
            case 'Table Lamp':
                return rand(20, 40) . 'x' . rand(20, 40) . 'x' . rand(40, 60) . ' cm';
            case 'Pendant Light':
                return rand(20, 40) . ' cm diameter, ' . rand(50, 100) . ' cm drop';
            default:
                return '';
        }
    }

    private function generateWattage($lampType)
    {
        switch ($lampType) {
            case 'LED':
                return rand(5, 20) . 'W';
            case 'Fluorescent':
                return rand(15, 40) . 'W';
            case 'Incandescent':
                return rand(40, 100) . 'W';
            case 'Halogen':
                return rand(20, 50) . 'W';
            case 'CFL':
                return rand(13, 23) . 'W';
            default:
                return '';
        }
    }

    private function generateLampColor()
    {
        $colors = ['Warm White (2700K)', 'Soft White (3000K)', 'Bright White (4000K)', 'Daylight (5000K)', 'Cool Daylight (6500K)'];
        return $colors[array_rand($colors)];
    }
}
