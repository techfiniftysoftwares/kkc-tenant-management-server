<?php

namespace Database\Seeders;

use App\Models\Part;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PartsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $parts = [
            [
                'name' => 'HVAC Filter',
                'description' => 'Air filter for HVAC systems',
                'part_number' => 'HVAC-FLT-001',
            ],
            [
                'name' => 'Belts',
                'description' => 'Drive belts for motors and fans',
                'part_number' => 'BELT-001',
            ],
            [
                'name' => 'Compressor Oil',
                'description' => 'Lubricating oil for compressors',
                'part_number' => 'OIL-COMP-001',
            ],
            [
                'name' => 'Refrigerant',
                'description' => 'Refrigerant gas for air conditioning systems',
                'part_number' => 'REFR-001',
            ],
            [
                'name' => 'Thermostat',
                'description' => 'Temperature control device',
                'part_number' => 'THERM-001',
            ],
            [
                'name' => 'Condenser Coil',
                'description' => 'Heat transfer coil for condensing units',
                'part_number' => 'COND-COIL-001',
            ],
            [
                'name' => 'Evaporator Coil',
                'description' => 'Heat transfer coil for evaporating units',
                'part_number' => 'EVAP-COIL-001',
            ],
            [
                'name' => 'Expansion Valve',
                'description' => 'Valve for regulating refrigerant flow',
                'part_number' => 'EXP-VALVE-001',
            ],
            [
                'name' => 'Condenser Fan Motor',
                'description' => 'Motor for condenser fan',
                'part_number' => 'COND-FAN-MOTOR-001',
            ],
            [
                'name' => 'Evaporator Fan Motor',
                'description' => 'Motor for evaporator fan',
                'part_number' => 'EVAP-FAN-MOTOR-001',
            ],
            [
                'name' => 'Ignition Control Module',
                'description' => 'Control module for ignition systems',
                'part_number' => 'IGN-CONTROL-001',
            ],
            [
                'name' => 'Gas Valve',
                'description' => 'Valve for controlling gas flow',
                'part_number' => 'GAS-VALVE-001',
            ],
            [
                'name' => 'Circulator Pump',
                'description' => 'Pump for circulating water or fluid',
                'part_number' => 'CIRC-PUMP-001',
            ],
            [
                'name' => 'Air Filter',
                'description' => 'Filter for removing airborne particles',
                'part_number' => 'AIR-FILTER-001',
            ],
            [
                'name' => 'Control Board',
                'description' => 'Main control board for HVAC systems',
                'part_number' => 'CONTROL-BOARD-001',
            ],
            [
                'name' => 'Capacitor',
                'description' => 'Electrical capacitor for motors and compressors',
                'part_number' => 'CAPACITOR-001',
            ],
            [
                'name' => 'Contactor',
                'description' => 'Electrical contactor for controlling power',
                'part_number' => 'CONTACTOR-001',
            ],
            [
                'name' => 'Transformer',
                'description' => 'Electrical transformer for voltage control',
                'part_number' => 'TRANSFORMER-001',
            ],
            [
                'name' => 'Pressure Switch',
                'description' => 'Switch for monitoring system pressure',
                'part_number' => 'PRES-SWITCH-001',
            ],
            [
                'name' => 'Flame Sensor',
                'description' => 'Sensor for detecting flame presence',
                'part_number' => 'FLAME-SENSOR-001',
            ],
        ];

        foreach ($parts as $part) {
            Part::create($part);
        }
    }
}