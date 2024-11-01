<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class WindowSeeder extends Seeder
{
    public function run()
    {
        $assetTypeId = DB::table('asset_types')->where('name', 'Fixture')->first()->id ?? null;
        if (!$assetTypeId) {
            throw new \Exception('Fixture asset type not found. Please ensure it exists in the asset_types table.');
        }

        $facilityId = 1; // As per your previous data
        $branchId = 1; // As per your previous data
        $buildingId = 1; // As per your previous data

        $windowTypes = ['Casement', 'Double-hung', 'Sliding', 'Fixed', 'Bay'];
        $glassTints = [null, 'Clear', 'Gray', 'Bronze', 'Green'];
        $glassCoatings = [null, 'Low-E', 'Reflective', 'Self-cleaning'];
        $frameMaterials = ['Aluminum', 'Vinyl', 'Wood', 'Fiberglass', 'Composite'];
        $openingMechanisms = ['Crank', 'Sliding', 'Push-out', 'Fixed', 'Tilt-and-turn'];
        $lockTypes = ['Cam lock', 'Sash lock', 'Cremone bolt', 'Folding handle'];
        $manufacturers = ['WindowCraft', 'GlassGuard', 'ClearView', 'ThermalShield', 'EcoGlaze'];

        for ($i = 1; $i <= 5; $i++) {
            $floorId = DB::table('floors')->inRandomOrder()->first()->id ?? null;
            $roomId = DB::table('rooms')->inRandomOrder()->first()->id ?? null;

            $windowType = $windowTypes[array_rand($windowTypes)];
            $frameMaterial = $frameMaterials[array_rand($frameMaterials)];
            $manufacturer = $manufacturers[array_rand($manufacturers)];

            $acquisitionDate = Carbon::now()->subDays(rand(0, 1095)); // Within last 3 years
            $warrantyYears = rand(1, 5);
            $warrantyStartDate = $acquisitionDate;
            $warrantyEndDate = $acquisitionDate->copy()->addYears($warrantyYears);

            $referenceNumber = $this->generateReferenceNumber($windowType, $i);

            // Create the asset first
            $assetId = DB::table('assets')->insertGetId([
                'asset_type_id' => $assetTypeId,
                'reference_number' => $referenceNumber,
                'name' => "{$windowType} Window {$i}",
                'description' => "A {$frameMaterial} {$windowType} window",
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
                'maintenance_schedule' => $this->generateMaintenanceSchedule(),
                'owner' => 'Facility Management Department',
                'barcode' => $this->generateBarcode($referenceNumber),
                'serial_number' => $this->generateSerialNumber($manufacturer),
                'manufacturer' => $manufacturer,
                'model_number' => $this->generateModelNumber($windowType, $frameMaterial),
                'status' => ['Active', 'Inactive', 'Under Maintenance'][rand(0, 2)],
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            // Now create the window
            DB::table('windows')->insert([
                'asset_id' => $assetId,
                'window_type' => $windowType,
                'window_size' => rand(24, 72) . 'x' . rand(24, 72),
                'glass_type' => ['Single-pane', 'Double-pane', 'Triple-pane'][rand(0, 2)],
                'glass_thickness' => rand(3, 6) . 'mm',
                'glass_tint' => $glassTints[array_rand($glassTints)],
                'glass_coating' => $glassCoatings[array_rand($glassCoatings)],
                'frame_material' => $frameMaterial,
                'frame_finish' => ['Painted', 'Anodized', 'Wood stain', 'Powder-coated'][rand(0, 3)],
                'sealant_type' => ['Silicone', 'Polyurethane', 'Acrylic'][rand(0, 2)],
                'weatherstripping_type' => ['Foam', 'Felt', 'Vinyl', 'Rubber'][rand(0, 3)],
                'screen_type' => rand(0, 1) ? ['Full', 'Half', 'Retractable'][rand(0, 2)] : null,
                'screen_material' => rand(0, 1) ? ['Fiberglass', 'Aluminum', 'Polyester'][rand(0, 2)] : null,
                'opening_mechanism' => $openingMechanisms[array_rand($openingMechanisms)],
                'lock_type' => $lockTypes[array_rand($lockTypes)],
                'lock_brand' => 'SecureWin ' . chr(rand(65, 90)),
                'sound_transmission_class' => 'STC ' . rand(25, 35),
                'u_value' => '0.' . rand(20, 35),
                'solar_heat_gain_coefficient' => '0.' . rand(20, 70),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }

    private function generateReferenceNumber($windowType, $number)
    {
        $prefix = 'WIN-' . substr($windowType, 0, 2);
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

    private function generateModelNumber($windowType, $material)
    {
        return strtoupper(substr($windowType, 0, 2) . substr($material, 0, 2)) . '-' . rand(1000, 9999);
    }

    private function generateMaintenanceSchedule()
    {
        $schedules = [
            "Monthly: Clean glass and check seals",
            "Half-yearly: Lubricate moving parts",
            "Yearly: Full window inspection and maintenance",
            "Monthly: Inspect weatherstripping",
            "Half-yearly: Check and adjust hardware",
            "Yearly: Repaint or refinish frames if needed"
        ];
        return $schedules[array_rand($schedules)];
    }
}
