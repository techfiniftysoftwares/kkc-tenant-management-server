<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ElectricalSeeder extends Seeder
{
    public function run()
    {
        $assetTypeId = DB::table('asset_types')->where('name', 'Electricals')->first()->id ?? null;
        if (!$assetTypeId) {
            throw new \Exception('Electricals asset type not found. Please ensure it exists in the asset_types table.');
        }

        $facilityId = 1; // As per your previous data
        $branchId = 1; // As per your previous data
        $buildingId = 1; // As per your previous data

        $electricalTypes = ['Circuit Breaker Panel', 'Power Outlet', 'Light Switch', 'GFCI Outlet', 'Junction Box'];
        $manufacturers = ['ElectroTech', 'PowerPro', 'CircuitMaster', 'VoltSafe', 'WireSolutions'];

        for ($i = 1; $i <= 5; $i++) {
            $floorId = DB::table('floors')->inRandomOrder()->first()->id ?? null;
            $roomId = DB::table('rooms')->inRandomOrder()->first()->id ?? null;

            $electricalType = $electricalTypes[$i - 1]; // Ensure we get one of each type
            $manufacturer = $manufacturers[array_rand($manufacturers)];

            $installationDate = Carbon::now()->subDays(rand(0, 1825)); // Within last 5 years
            $acquisitionDate = $installationDate->copy()->subDays(rand(7, 30)); // Acquisition a bit before installation
            $warrantyYears = rand(1, 10);
            $warrantyStartDate = $installationDate;
            $warrantyEndDate = $installationDate->copy()->addYears($warrantyYears);

            $referenceNumber = $this->generateReferenceNumber($electricalType, $i);

            // Create the asset first
            $assetId = DB::table('assets')->insertGetId([
                'asset_type_id' => $assetTypeId,
                'reference_number' => $referenceNumber,
                'name' => "{$electricalType}",
                'description' => "A {$electricalType} installed for electrical distribution and control",
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
                'maintenance_schedule' => $this->generateMaintenanceSchedule($electricalType),
                'owner' => 'Facility Management Department',
                'barcode' => $this->generateBarcode($referenceNumber),
                'serial_number' => $this->generateSerialNumber($manufacturer),
                'manufacturer' => $manufacturer,
                'model_number' => $this->generateModelNumber($electricalType),
                'status' => ['Active', 'Inactive', 'Under Maintenance'][rand(0, 2)],
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            // Now create the electrical
            DB::table('electricals')->insert([
                'asset_id' => $assetId,
                'electrical_type' => $electricalType,
                'voltage' => $this->generateVoltage($electricalType),
                'amperage' => $this->generateAmperage($electricalType),
                'wire_gauge' => $this->generateWireGauge(),
                'wire_type' => $this->generateWireType(),
                'conduit_type' => $this->generateConduitType(),
                'conduit_size' => $this->generateConduitSize(),
                'switch_type' => $this->generateSwitchType($electricalType),
                'switch_rating' => $this->generateSwitchRating($electricalType),
                'receptacle_type' => $this->generateReceptacleType($electricalType),
                'receptacle_rating' => $this->generateReceptacleRating($electricalType),
                'circuit_breaker_type' => $this->generateCircuitBreakerType($electricalType),
                'circuit_breaker_rating' => $this->generateCircuitBreakerRating($electricalType),
                'installation_date' => $installationDate,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }

    private function generateReferenceNumber($electricalType, $number)
    {
        $prefix = 'ELC-' . substr(str_replace(' ', '', $electricalType), 0, 2);
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

    private function generateModelNumber($electricalType)
    {
        return strtoupper(substr(str_replace(' ', '', $electricalType), 0, 4)) . '-' . rand(1000, 9999);
    }

    private function generateMaintenanceSchedule($electricalType)
    {
        $schedules = [
            "Monthly: Visual inspection",
            "Quarterly: Test and verify proper operation",
            "Yearly: Comprehensive inspection and testing",
            "Bi-annually: Thermal imaging scan",
        ];
        return $schedules[array_rand($schedules)];
    }

    private function generateVoltage($electricalType)
    {
        return $electricalType == 'Circuit Breaker Panel' ? '240V' : '120V';
    }

    private function generateAmperage($electricalType)
    {
        switch ($electricalType) {
            case 'Circuit Breaker Panel':
                return ['100A', '200A', '400A'][rand(0, 2)];
            case 'Power Outlet':
            case 'GFCI Outlet':
                return '15A';
            default:
                return '20A';
        }
    }

    private function generateWireGauge()
    {
        return ['14 AWG', '12 AWG', '10 AWG', '8 AWG'][rand(0, 3)];
    }

    private function generateWireType()
    {
        return ['THHN', 'XHHW', 'NM-B', 'UF-B'][rand(0, 3)];
    }

    private function generateConduitType()
    {
        return ['EMT', 'PVC', 'Rigid', 'Flexible'][rand(0, 3)];
    }

    private function generateConduitSize()
    {
        return ['1/2"', '3/4"', '1"', '1 1/4"'][rand(0, 3)];
    }

    private function generateSwitchType($electricalType)
    {
        return $electricalType == 'Light Switch' ? ['Single-pole', 'Three-way', 'Four-way', 'Dimmer'][rand(0, 3)] : 'N/A';
    }

    private function generateSwitchRating($electricalType)
    {
        return $electricalType == 'Light Switch' ? ['15A', '20A'][rand(0, 1)] : 'N/A';
    }

    private function generateReceptacleType($electricalType)
    {
        if (in_array($electricalType, ['Power Outlet', 'GFCI Outlet'])) {
            return $electricalType == 'GFCI Outlet' ? 'GFCI' : ['Duplex', 'GFCI', 'USB'][rand(0, 2)];
        }
        return 'N/A';
    }

    private function generateReceptacleRating($electricalType)
    {
        return in_array($electricalType, ['Power Outlet', 'GFCI Outlet']) ? '15A/125V' : 'N/A';
    }

    private function generateCircuitBreakerType($electricalType)
    {
        return $electricalType == 'Circuit Breaker Panel' ? ['Single-pole', 'Double-pole', 'GFCI', 'AFCI'][rand(0, 3)] : 'N/A';
    }

    private function generateCircuitBreakerRating($electricalType)
    {
        return $electricalType == 'Circuit Breaker Panel' ? ['15A', '20A', '30A', '50A'][rand(0, 3)] : 'N/A';
    }
}
