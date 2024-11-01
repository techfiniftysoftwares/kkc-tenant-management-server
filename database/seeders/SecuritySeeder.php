<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class SecuritySeeder extends Seeder
{
    public function run()
    {
        $assetTypeId = DB::table('asset_types')->where('name', 'Security')->first()->id ?? null;
        if (!$assetTypeId) {
            throw new \Exception('Security asset type not found. Please ensure it exists in the asset_types table.');
        }

        $facilityId = 1; // As per your previous data
        $branchId = 1; // As per your previous data
        $buildingId = 1; // As per your previous data

        $securityTypes = ['CCTV', 'Alarm System', 'Access Control'];
        $manufacturers = ['Hikvision', 'Dahua', 'Bosch', 'Honeywell', 'Axis'];

        for ($i = 1; $i <= 5; $i++) {
            $floorId = DB::table('floors')->inRandomOrder()->first()->id ?? null;

            // Randomly choose between common area, corridor, and room
            $locationRand = rand(0, 2);
            if ($locationRand == 0) {
                $commonAreaId = DB::table('common_areas')->inRandomOrder()->first()->id ?? null;
                $corridorId = null;
                $roomId = null;
                $location = "Common Area";
            } elseif ($locationRand == 1) {
                $commonAreaId = null;
                $corridorId = DB::table('corridors')->inRandomOrder()->first()->id ?? null;
                $roomId = null;
                $location = "Corridor";
            } else {
                $commonAreaId = null;
                $corridorId = null;
                $roomId = DB::table('rooms')->inRandomOrder()->first()->id ?? null;
                $location = "Room";
            }

            $securityType = $securityTypes[$i % 3]; // Cycle through security types
            $manufacturer = $manufacturers[array_rand($manufacturers)];

            $installationDate = Carbon::now()->subDays(rand(0, 3650)); // Within last 10 years
            $acquisitionDate = $installationDate->copy()->subDays(rand(7, 30)); // Acquisition a bit before installation
            $warrantyYears = rand(1, 5);
            $warrantyStartDate = $installationDate;
            $warrantyEndDate = $installationDate->copy()->addYears($warrantyYears);

            $referenceNumber = $this->generateReferenceNumber($securityType, $i);

            // Create the asset first
            $assetId = DB::table('assets')->insertGetId([
                'asset_type_id' => $assetTypeId,
                'reference_number' => $referenceNumber,
                'name' => "{$manufacturer} {$securityType} System",
                'description' => "A {$securityType} system manufactured by {$manufacturer}, located in {$location}",
                'facility_id' => $facilityId,
                'branch_id' => $branchId,
                'building_id' => $buildingId,
                'floor_id' => $floorId,
                'common_area_id' => $commonAreaId,
                'corridor_id' => $corridorId,
                'room_id' => $roomId,
                'acquisition_date' => $acquisitionDate,
                'supplier_id' => DB::table('suppliers')->inRandomOrder()->first()->id ?? null,
                'warranty_start_date' => $warrantyStartDate,
                'warranty_end_date' => $warrantyEndDate,
                'condition' => ['Excellent', 'Good', 'Fair', 'Poor'][rand(0, 3)],
                'maintenance_schedule' => $this->generateMaintenanceSchedule(),
                'owner' => 'Security Department',
                'barcode' => $this->generateBarcode($referenceNumber),
                'serial_number' => $this->generateSerialNumber($manufacturer),
                'manufacturer' => $manufacturer,
                'model_number' => $this->generateModelNumber($securityType),
                'status' => ['Active', 'Inactive', 'Under Maintenance'][rand(0, 2)],
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            // Now create the security record
            DB::table('securities')->insert([
                'asset_id' => $assetId,
                'security_type' => $securityType,
                'camera_type' => $this->generateCameraType($securityType),
                'camera_resolution' => $this->generateCameraResolution($securityType),
                'camera_lens_type' => $this->generateCameraLensType($securityType),
                'camera_infrared_capability' => $this->generateCameraInfraredCapability($securityType),
                'recorder_type' => $this->generateRecorderType($securityType),
                'recorder_storage_capacity' => $this->generateRecorderStorageCapacity($securityType),
                'alarm_system_type' => $this->generateAlarmSystemType($securityType),
                'alarm_system_keypad_type' => $this->generateAlarmSystemKeypadType($securityType),
                'motion_detector_type' => $this->generateMotionDetectorType($securityType),
                'glass_break_detector_type' => $this->generateGlassBreakDetectorType($securityType),
                'door_contact_type' => $this->generateDoorContactType($securityType),
                'access_control_system_type' => $this->generateAccessControlSystemType($securityType),
                'access_control_reader_type' => $this->generateAccessControlReaderType($securityType),
                'installation_date' => $installationDate,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }

    private function generateReferenceNumber($securityType, $number)
    {
        $prefix = 'SEC-' . substr($securityType, 0, 2);
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

    private function generateModelNumber($securityType)
    {
        return strtoupper(substr($securityType, 0, 3)) . '-' . rand(1000, 9999);
    }

    private function generateMaintenanceSchedule()
    {
        $schedules = [
            "Monthly: Inspection and cleaning",
            "Quarterly: System testing",
            "Bi-annually: Software updates",
            "Yearly: Full system maintenance",
        ];
        return $schedules[array_rand($schedules)];
    }

    private function generateCameraType($securityType)
    {
        if ($securityType === 'CCTV') {
            return ['Bullet', 'Dome', 'PTZ', 'Turret'][rand(0, 3)];
        }
        return null;
    }

    private function generateCameraResolution($securityType)
    {
        if ($securityType === 'CCTV') {
            return ['720p', '1080p', '4K'][rand(0, 2)];
        }
        return null;
    }

    private function generateCameraLensType($securityType)
    {
        if ($securityType === 'CCTV') {
            return ['Fixed', 'Varifocal'][rand(0, 1)];
        }
        return null;
    }

    private function generateCameraInfraredCapability($securityType)
    {
        if ($securityType === 'CCTV') {
            return rand(0, 1) === 1;
        }
        return false;
    }

    private function generateRecorderType($securityType)
    {
        if ($securityType === 'CCTV') {
            return ['DVR', 'NVR'][rand(0, 1)];
        }
        return null;
    }

    private function generateRecorderStorageCapacity($securityType)
    {
        if ($securityType === 'CCTV') {
            return rand(1, 10) . ' TB';
        }
        return null;
    }

    private function generateAlarmSystemType($securityType)
    {
        if ($securityType === 'Alarm System') {
            return ['Wired', 'Wireless'][rand(0, 1)];
        }
        return 'N/A';
    }

    private function generateAlarmSystemKeypadType($securityType)
    {
        if ($securityType === 'Alarm System') {
            return ['Numeric', 'Alphanumeric', 'Touchscreen'][rand(0, 2)];
        }
        return 'N/A';
    }

    private function generateMotionDetectorType($securityType)
    {
        if ($securityType === 'Alarm System') {
            return ['PIR', 'Microwave', 'Dual Technology'][rand(0, 2)];
        }
        return null;
    }

    private function generateGlassBreakDetectorType($securityType)
    {
        if ($securityType === 'Alarm System') {
            return ['Acoustic', 'Shock'][rand(0, 1)];
        }
        return null;
    }

    private function generateDoorContactType($securityType)
    {
        if ($securityType === 'Alarm System') {
            return ['Recessed', 'Surface Mount'][rand(0, 1)];
        }
        return null;
    }

    private function generateAccessControlSystemType($securityType)
    {
        if ($securityType === 'Access Control') {
            return ['Card', 'Biometric', 'Keypad'][rand(0, 2)];
        }
        return 'N/A';
    }

    private function generateAccessControlReaderType($securityType)
    {
        if ($securityType === 'Access Control') {
            return ['Proximity', 'Smart Card', 'Fingerprint'][rand(0, 2)];
        }
        return 'N/A';
    }
}
