<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class HVACSeeder extends Seeder
{
    public function run()
    {
        $assetTypeId = DB::table('asset_types')->where('name', 'HVAC')->first()->id ?? null;
        if (!$assetTypeId) {
            throw new \Exception('HVAC asset type not found. Please ensure it exists in the asset_types table.');
        }

        $facilityId = 1; // As per your previous data
        $branchId = 1; // As per your previous data
        $buildingId = 1; // As per your previous data

        $hvacTypes = ['Split System', 'Packaged Unit', 'Heat Pump', 'Ductless Mini-Split', 'VRF System'];
        $manufacturers = ['Carrier', 'Trane', 'Lennox', 'Daikin', 'Rheem'];

        for ($i = 1; $i <= 5; $i++) {
            $floorId = DB::table('floors')->inRandomOrder()->first()->id ?? null;
            $roomId = DB::table('rooms')->inRandomOrder()->first()->id ?? null;

            $hvacType = $hvacTypes[$i - 1]; // Ensure we get one of each type
            $manufacturer = $manufacturers[array_rand($manufacturers)];

            $installationDate = Carbon::now()->subDays(rand(0, 3650)); // Within last 10 years
            $acquisitionDate = $installationDate->copy()->subDays(rand(7, 30)); // Acquisition a bit before installation
            $warrantyYears = rand(5, 15);
            $warrantyStartDate = $installationDate;
            $warrantyEndDate = $installationDate->copy()->addYears($warrantyYears);

            $referenceNumber = $this->generateReferenceNumber($hvacType, $i);

            // Create the asset first
            $assetId = DB::table('assets')->insertGetId([
                'asset_type_id' => $assetTypeId,
                'reference_number' => $referenceNumber,
                'name' => "{$manufacturer} {$hvacType}",
                'description' => "A {$hvacType} HVAC system manufactured by {$manufacturer}",
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
                'model_number' => $this->generateModelNumber($hvacType),
                'status' => ['Active', 'Inactive', 'Under Maintenance'][rand(0, 2)],
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            // Now create the HVAC
            DB::table('hvacs')->insert([
                'asset_id' => $assetId,
                'hvac_type' => $hvacType,
                'capacity' => $this->generateCapacity(),
                'efficiency' => $this->generateEfficiency($hvacType),
                'refrigerant_type' => $this->generateRefrigerantType(),
                'air_filter_type' => $this->generateAirFilterType(),
                'air_filter_merv' => $this->generateAirFilterMERV(),
                'duct_material' => $this->generateDuctMaterial(),
                'duct_insulation_r_value' => $this->generateDuctInsulationRValue(),
                'control_system_type' => $this->generateControlSystemType(),
                'control_system_brand' => $this->generateControlSystemBrand(),
                'thermostat_type' => $this->generateThermostatType(),
                'thermostat_brand' => $this->generateThermostatBrand(),
                'installation_date' => $installationDate,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }

    private function generateReferenceNumber($hvacType, $number)
    {
        $prefix = 'HVAC-' . substr(str_replace(' ', '', $hvacType), 0, 2);
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

    private function generateModelNumber($hvacType)
    {
        return strtoupper(substr(str_replace(' ', '', $hvacType), 0, 4)) . '-' . rand(1000, 9999);
    }

    private function generateMaintenanceSchedule()
    {
        $schedules = [
            "Monthly: Change air filters",
            "Quarterly: Check and clean condensate drain",
            "Bi-annually: Professional inspection and tune-up",
            "Yearly: Clean ducts and check for leaks",
        ];
        return $schedules[array_rand($schedules)];
    }

    private function generateCapacity()
    {
        return rand(1, 5) . ' ton';
    }

    private function generateEfficiency($hvacType)
    {
        switch ($hvacType) {
            case 'Heat Pump':
                return rand(14, 22) . ' SEER / ' . rand(8, 13) . ' HSPF';
            default:
                return rand(14, 22) . ' SEER';
        }
    }

    private function generateRefrigerantType()
    {
        return ['R-410A', 'R-32', 'R-134a'][rand(0, 2)];
    }

    private function generateAirFilterType()
    {
        return ['Fiberglass', 'Pleated', 'Electrostatic', 'HEPA'][rand(0, 3)];
    }

    private function generateAirFilterMERV()
    {
        return 'MERV ' . rand(8, 16);
    }

    private function generateDuctMaterial()
    {
        return ['Galvanized Steel', 'Aluminum', 'Flexible Plastic', 'Fiberglass'][rand(0, 3)];
    }

    private function generateDuctInsulationRValue()
    {
        return 'R-' . rand(4, 8);
    }

    private function generateControlSystemType()
    {
        return ['Programmable', 'Smart', 'Zone Control', 'BMS Integration'][rand(0, 3)];
    }

    private function generateControlSystemBrand()
    {
        return ['Honeywell', 'Nest', 'Ecobee', 'Johnson Controls'][rand(0, 3)];
    }

    private function generateThermostatType()
    {
        return ['Programmable', 'Smart', 'Non-programmable', 'Wi-Fi Enabled'][rand(0, 3)];
    }

    private function generateThermostatBrand()
    {
        return ['Honeywell', 'Nest', 'Ecobee', 'Emerson'][rand(0, 3)];
    }
}
