<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ElevatorSeeder extends Seeder
{
    public function run()
    {
        $assetTypeId = DB::table('asset_types')->where('name', 'Elevator')->first()->id ?? null;
        if (!$assetTypeId) {
            throw new \Exception('Elevator asset type not found. Please ensure it exists in the asset_types table.');
        }

        $facilityId = 3; // As per your previous data
        $branchId = 8; // As per your previous data
        $buildingId = 3; // As per your previous data

        $elevatorTypes = ['Passenger', 'Freight', 'Service', 'Panoramic', 'Hospital'];
        $manufacturers = ['Otis', 'KONE', 'Schindler', 'ThyssenKrupp', 'Mitsubishi Electric'];

        for ($i = 1; $i <= 5; $i++) {
            $floorId = DB::table('floors')->inRandomOrder()->first()->id ?? null;

            // Randomly choose between common area and corridor
            if (rand(0, 1) == 0) {
                $commonAreaId = DB::table('common_areas')->inRandomOrder()->first()->id ?? null;
                $corridorId = null;
                $location = "Common Area";
            } else {
                $commonAreaId = null;
                $corridorId = DB::table('corridors')->inRandomOrder()->first()->id ?? null;
                $location = "Corridor";
            }

            $elevatorType = $elevatorTypes[$i - 1]; // Ensure we get one of each type
            $manufacturer = $manufacturers[array_rand($manufacturers)];

            $installationDate = Carbon::now()->subDays(rand(0, 3650)); // Within last 10 years
            $acquisitionDate = $installationDate->copy()->subDays(rand(7, 30)); // Acquisition a bit before installation
            $warrantyYears = rand(5, 15);
            $warrantyStartDate = $installationDate;
            $warrantyEndDate = $installationDate->copy()->addYears($warrantyYears);

            $referenceNumber = $this->generateReferenceNumber($elevatorType, $i);

            // Create the asset first
            $assetId = DB::table('assets')->insertGetId([
                'asset_type_id' => $assetTypeId,
                'reference_number' => $referenceNumber,
                'name' => "{$manufacturer} {$elevatorType} Elevator",
                'description' => "A {$elevatorType} elevator manufactured by {$manufacturer}, located in {$location}",
                'facility_id' => $facilityId,
                'branch_id' => $branchId,
                'building_id' => $buildingId,
                'floor_id' => $floorId,
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
                'model_number' => $this->generateModelNumber($elevatorType),
                'status' => ['Active', 'Inactive', 'Under Maintenance'][rand(0, 2)],
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            // Now create the elevator
            DB::table('elevators')->insert([
                'asset_id' => $assetId,
                'elevator_type' => $elevatorType,
                'capacity' => $this->generateCapacity($elevatorType),
                'speed' => $this->generateSpeed(),
                'motor_type' => $this->generateMotorType(),
                'motor_power' => $this->generateMotorPower(),
                'cable_type' => $this->generateCableType(),
                'cable_diameter' => $this->generateCableDiameter(),
                'brake_type' => $this->generateBrakeType(),
                'control_system_type' => $this->generateControlSystemType(),
                'control_system_brand' => $this->generateControlSystemBrand(),
                'door_operator_type' => $this->generateDoorOperatorType(),
                'door_safety_type' => $this->generateDoorSafetyType(),
                'car_enclosure_material' => $this->generateCarEnclosureMaterial(),
                'car_enclosure_finish' => $this->generateCarEnclosureFinish(),
                'installation_date' => $installationDate,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }

    private function generateReferenceNumber($elevatorType, $number)
    {
        $prefix = 'ELV-' . substr($elevatorType, 0, 2);
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

    private function generateModelNumber($elevatorType)
    {
        return strtoupper(substr($elevatorType, 0, 3)) . '-' . rand(1000, 9999);
    }

    private function generateMaintenanceSchedule()
    {
        $schedules = [
            "Monthly: Safety check and lubrication",
            "Quarterly: Comprehensive inspection",
            "Bi-annually: Load testing",
            "Yearly: Full system maintenance and certification",
        ];
        return $schedules[array_rand($schedules)];
    }

    private function generateCapacity($elevatorType)
    {
        switch ($elevatorType) {
            case 'Passenger':
                return rand(10, 20) . ' persons / ' . rand(750, 1500) . ' kg';
            case 'Freight':
                return rand(2000, 5000) . ' kg';
            case 'Service':
                return rand(1000, 2000) . ' kg';
            case 'Panoramic':
                return rand(8, 15) . ' persons / ' . rand(600, 1125) . ' kg';
            case 'Hospital':
                return rand(1500, 2500) . ' kg';
            default:
                return '';
        }
    }

    private function generateSpeed()
    {
        return rand(10, 60) / 10 . ' m/s';
    }

    private function generateMotorType()
    {
        return ['Geared Traction', 'Gearless Traction', 'Hydraulic'][rand(0, 2)];
    }

    private function generateMotorPower()
    {
        return rand(5, 50) . ' kW';
    }

    private function generateCableType()
    {
        return ['Steel', 'Aramid Fiber', 'Coated Steel'][rand(0, 2)];
    }

    private function generateCableDiameter()
    {
        return rand(8, 16) . ' mm';
    }

    private function generateBrakeType()
    {
        return ['Electromagnetic', 'Hydraulic', 'Disc'][rand(0, 2)];
    }

    private function generateControlSystemType()
    {
        return ['Microprocessor', 'PLC', 'Relay Logic'][rand(0, 2)];
    }

    private function generateControlSystemBrand()
    {
        return ['Siemens', 'ABB', 'Schneider Electric', 'Mitsubishi'][rand(0, 3)];
    }

    private function generateDoorOperatorType()
    {
        return ['Linear', 'Rotary', 'Belt-driven'][rand(0, 2)];
    }

    private function generateDoorSafetyType()
    {
        return ['Light Curtain', 'Safety Edge', 'Infrared Sensor'][rand(0, 2)];
    }

    private function generateCarEnclosureMaterial()
    {
        return ['Stainless Steel', 'Laminate', 'Glass', 'Wood Veneer'][rand(0, 3)];
    }

    private function generateCarEnclosureFinish()
    {
        return ['Brushed', 'Polished', 'Powder-coated', 'Textured'][rand(0, 3)];
    }
}
