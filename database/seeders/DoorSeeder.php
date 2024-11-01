<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DoorSeeder extends Seeder
{
    public function run()
    {
        $assetTypeId = DB::table('asset_types')->where('name', 'Door')->first()->id ?? null;
        if (!$assetTypeId) {
            throw new \Exception('Door asset type not found. Please ensure it exists in the asset_types table.');
        }

        $facilityId = 1;
        $branchId = 1;
        $buildingId = 1;

        $doorTypes = ['Sliding', 'Swing', 'Folding', 'Revolving', 'Automatic'];
        $materials = ['Wood', 'Metal', 'Glass', 'Fiberglass', 'Composite'];
        $finishes = ['Painted', 'Stained', 'Varnished', 'Powder-coated', 'Anodized'];
        $colors = ['White', 'Brown', 'Black', 'Gray', 'Natural'];
        $manufacturers = ['DoorCo', 'SafeGuard', 'EcoEntrance', 'DuraDoor', 'SecureAccess'];

        for ($i = 1; $i <= 5; $i++) {
            $floorId = DB::table('floors')->inRandomOrder()->first()->id ?? null;
            $roomId = DB::table('rooms')->inRandomOrder()->first()->id ?? null;

            $doorType = $doorTypes[$i - 1]; // Ensure we get one of each type
            $material = $materials[array_rand($materials)];
            $finish = $finishes[array_rand($finishes)];
            $color = $colors[array_rand($colors)];
            $manufacturer = $manufacturers[array_rand($manufacturers)];

            $installationDate = Carbon::now()->subDays(rand(0, 1825)); // Within last 5 years
            $acquisitionDate = $installationDate->copy()->subDays(rand(7, 30)); // Acquisition a bit before installation
            $warrantyYears = rand(1, 5);
            $warrantyStartDate = $installationDate;
            $warrantyEndDate = $installationDate->copy()->addYears($warrantyYears);

            $referenceNumber = $this->generateReferenceNumber($doorType, $i);

            // Create the asset first
            $assetId = DB::table('assets')->insertGetId([
                'asset_type_id' => $assetTypeId,
                'reference_number' => $referenceNumber,
                'name' => "{$color} {$material} {$doorType} Door",
                'description' => "A {$color} {$doorType} door made of {$material} with {$finish} finish",
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
                'model_number' => $this->generateModelNumber($doorType, $material),
                'status' => ['Active', 'Inactive', 'Under Maintenance'][rand(0, 2)],
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            // Now create the door
            DB::table('doors')->insert([
                'asset_id' => $assetId,
                'door_type' => $doorType,
                'door_material' => $material,
                'door_size' => $this->generateDoorSize(),
                'door_fire_rating' => $this->generateFireRating(),
                'door_sound_transmission_class' => $this->generateSoundTransmissionClass(),
                'hinge_type' => $this->generateHingeType(),
                'lock_type' => $this->generateLockType(),
                'lock_brand' => 'SecureLock ' . chr(rand(65, 90)),
                'lock_key_type' => $this->generateLockKeyType(),
                'door_closer_type' => rand(0, 1) ? $this->generateDoorCloserType() : null,
                'door_closer_brand' => rand(0, 1) ? 'CloseMaster ' . chr(rand(65, 90)) : null,
                'handle_type' => $this->generateHandleType(),
                'handle_material' => $materials[array_rand($materials)],
                'threshold_material' => rand(0, 1) ? $materials[array_rand($materials)] : null,
                'weatherstripping_type' => rand(0, 1) ? $this->generateWeatherstrippingType() : null,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }

    private function generateReferenceNumber($doorType, $number)
    {
        $prefix = 'DR-' . substr($doorType, 0, 2);
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

    private function generateModelNumber($doorType, $material)
    {
        return strtoupper(substr($doorType, 0, 2) . substr($material, 0, 2)) . '-' . rand(1000, 9999);
    }

    private function generateMaintenanceSchedule()
    {
        $schedules = [
            "Monthly: Check and lubricate hinges",
            "Quarterly: Inspect locks and handles",
            "Bi-annually: Full door inspection and maintenance",
            "Yearly: Repaint or refinish as necessary",
        ];
        return $schedules[array_rand($schedules)];
    }

    private function generateFireRating()
    {
        $ratings = ['20 minutes', '30 minutes', '60 minutes', '90 minutes', '120 minutes', 'N/A'];
        return $ratings[array_rand($ratings)];
    }

    private function generateDoorSize()
    {
        $width = rand(60, 120); // in cm
        $height = rand(180, 240); // in cm
        return "{$width}cm x {$height}cm";
    }

    private function generateSoundTransmissionClass()
    {
        return 'STC-' . rand(20, 60);
    }

    private function generateHingeType()
    {
        $types = ['Butt hinge', 'Pivot hinge', 'Barrel hinge', 'Concealed hinge', 'Piano hinge'];
        return $types[array_rand($types)];
    }

    private function generateLockType()
    {
        $types = ['Deadbolt', 'Knob lock', 'Lever handle', 'Smart lock', 'Keypad lock', 'Card reader'];
        return $types[array_rand($types)];
    }

    private function generateLockKeyType()
    {
        $types = ['Traditional key', 'Keycard', 'Keypad code', 'Biometric', 'Smartphone app'];
        return $types[array_rand($types)];
    }

    private function generateDoorCloserType()
    {
        $types = ['Hydraulic', 'Pneumatic', 'Spring-loaded', 'Concealed'];
        return $types[array_rand($types)];
    }

    private function generateHandleType()
    {
        $types = ['Lever', 'Knob', 'Pull handle', 'Push plate', 'Panic bar'];
        return $types[array_rand($types)];
    }

    private function generateWeatherstrippingType()
    {
        $types = ['Foam tape', 'V-strip', 'Door sweep', 'Tubular rubber', 'Magnetic'];
        return $types[array_rand($types)];
    }
}
