<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\EquipmentType;
use App\Models\Equipment;

class EquipmentsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        // Create equipment types
        $coolingType = EquipmentType::create(['name' => 'Cooling']);
        $powerType = EquipmentType::create(['name' => 'Power']);
        $securityType = EquipmentType::create(['name' => 'Security']);
        $fireType = EquipmentType::create(['name' => 'Fire']);

        // Insert cooling equipments
        Equipment::create([
            'equipment_type_id' => $coolingType->id,
            'reference' => 'CH/V1/01',
            'description' => 'AIR COOLED SCROLL CHILLER',
            'area_served' => 'Sits on the roof and serves the AHUs',
            'manufacturer' => 'Carrier',
            'cooling_capacity_kw' => 301,
            'outdoor_model' => '30RB-310R',
            'warranty_expiry' => '2024-10-01',
        ]);

        Equipment::create([
            'equipment_type_id' => $coolingType->id,
            'reference' => 'ASHP/V1/01',
            'description' => 'AIR SOURCE HEAT PUMP',
            'area_served' => 'Sits on the roof and serves the AHUs',
            'manufacturer' => 'Carrier',
            'cooling_capacity_kw' => 160,
            'heating_capacity_kw' => 135,
            'outdoor_model' => '30RQ-165R',
            'warranty_expiry' => '2024-10-01',
        ]);

        Equipment::create([
            'equipment_type_id' => $coolingType->id,
            'reference' => 'AHU/V1/02',
            'description' => 'AIR HANDLING UNIT',
            'area_served' => '(GROUND FLOOR DATA HALL A)',
            'manufacturer' => 'Carrier',
            'cooling_capacity_kw' => 16.9,
            'heating_capacity_kw' => 7.7,
            'indoor_model' => '39HQ 05.04/05.04',
            'warranty_expiry' => '2024-10-01',
        ]);

        Equipment::create([
            'equipment_type_id' => $coolingType->id,
            'reference' => 'AHU/V1/04',
            'description' => 'AIR HANDLING UNIT',
            'area_served' => '(GROUND FLOOR SWITCH ROOMS AND CORRIDOR)',
            'manufacturer' => 'Carrier',
            'cooling_capacity_kw' => 87.7,
            'heating_capacity_kw' => 39.8,
            'indoor_model' => '39HQ 09.06/09.06',
            'warranty_expiry' => '2024-10-01',
        ]);

        Equipment::create([
            'equipment_type_id' => $coolingType->id,
            'reference' => 'CRAH/V1/UPS/A/1',
            'description' => 'DX type free cooling unit',
            'area_served' => 'GROUND FLOOR UPS ROOM A/SWITCH ROOM A',
            'manufacturer' => 'Flaktgroup multi denco',
            'cooling_capacity_kw' => 64.4,
            'indoor_model' => 'DMF065DLCIN4PN1',
            'outdoor_model' => 'DMOUHM075E1',
            'warranty_expiry' => '2024-10-01',
        ]);

        Equipment::create([
            'equipment_type_id' => $coolingType->id,
            'reference' => 'CRAH/V1/UPS/A/2',
            'description' => 'DX type free cooling unit',
            'area_served' => 'GROUND FLOOR UPS ROOM A/SWITCH ROOM A',
            'manufacturer' => 'Flaktgroup multi denco',
            'cooling_capacity_kw' => 64.4,
            'indoor_model' => 'DMF065DLCIN4PN1',
            'outdoor_model' => 'DMOUHM075E1',
            'warranty_expiry' => '2024-10-01',
        ]);

        Equipment::create([
            'equipment_type_id' => $coolingType->id,
            'reference' => 'CRAH/V1/UPS/B/3',
            'description' => 'DX type free cooling unit',
            'area_served' => 'GROUND FLOOR UPS ROOM B/SWITCHROOM B',
            'manufacturer' => 'Flaktgroup multi denco',
            'cooling_capacity_kw' => 64.4,
            'indoor_model' => 'DMF065DLCIN4PN1',
            'outdoor_model' => 'DMOUHM075E1',
            'warranty_expiry' => '2024-10-01',
        ]);

        Equipment::create([
            'equipment_type_id' => $coolingType->id,
            'reference' => 'CRAH/V1/MMR/1/1',
            'description' => 'DX type free cooling unit',
            'area_served' => 'GROUND FLOOR MEET ME ROOMS A',
            'manufacturer' => 'Flaktgroup multi denco',
            'cooling_capacity_kw' => 26.6,
            'indoor_model' => 'DMF030DLCIN4PN1',
            'outdoor_model' => 'DMOUHM032E1',
            'warranty_expiry' => '2024-10-01',
        ]);

        Equipment::create([
            'equipment_type_id' => $coolingType->id,
            'reference' => 'CRAH/V1/MMR/1/2',
            'description' => 'DX type free cooling unit -',
            'area_served' => 'GROUND FLOOR MEET ME ROOMS A',
            'manufacturer' => 'Flaktgroup multi denco',
            'cooling_capacity_kw' => 26.6,
            'indoor_model' => 'DMF030DLCIN4PN1',
            'outdoor_model' => 'DMOUHM032E1',
            'warranty_expiry' => '2024-10-01',
        ]);

        Equipment::create([
            'equipment_type_id' => $coolingType->id,
            'reference' => 'CRAH/V1/MMR/2/1',
            'description' => 'DX type free cooling unit',
            'area_served' => 'GROUND FLOOR MEET ME ROOMS B',
            'manufacturer' => 'Flaktgroup multi denco',
            'cooling_capacity_kw' => 26.6,
            'indoor_model' => 'DMF030DLCIN4PN1',
            'outdoor_model' => 'DMOUHM032E1',
            'warranty_expiry' => '2024-10-01',
        ]);

        Equipment::create([
            'equipment_type_id' => $coolingType->id,
            'reference' => 'CRAH/V1/MMR/2/2',
            'description' => 'DX type free cooling unit',
            'area_served' => 'GROUND FLOOR MEET ME ROOMS B',
            'manufacturer' => 'Flaktgroup multi denco',
            'cooling_capacity_kw' => 26.6,
            'indoor_model' => 'DMF030DLCIN4PN1',
            'outdoor_model' => 'DMOUHM032E1',
            'warranty_expiry' => '2024-10-01',
        ]);

        Equipment::create([
            'equipment_type_id' => $coolingType->id,
            'reference' => 'CRAH/V1/BATT/A/01',
            'description' => 'DX type HIWALL UNIT',
            'area_served' => 'GROUND FLOOR BATTERY ROOM A',
            'manufacturer' => 'Toshiba',
            'warranty_expiry' => '2024-10-01',
        ]);

        Equipment::create([
            'equipment_type_id' => $coolingType->id,
            'reference' => 'CRAH/V1/BATT/A/02',
            'description' => 'DX type HIWALL UNIT',
            'area_served' => 'GROUND FLOOR BATTERY ROOM A',
            'manufacturer' => 'Toshiba',
            'warranty_expiry' => '2024-10-01',
        ]);

        Equipment::create([
            'equipment_type_id' => $coolingType->id,
            'reference' => 'CRAH/V1/BATT/A/03',
            'description' => 'DX type HIWALL UNIT',
            'area_served' => 'GROUND FLOOR BATTERY ROOM A',
            'manufacturer' => 'Toshiba',
            'warranty_expiry' => '2024-10-01',
        ]);

        Equipment::create([
            'equipment_type_id' => $coolingType->id,
            'reference' => 'CRAH/V1/BATT/B/01',
            'description' => 'DX type HIWALL UNIT',
            'area_served' => 'GROUND FLOOR BATTERY ROOM B',
            'manufacturer' => 'Toshiba',
            'warranty_expiry' => '2024-10-01',
        ]);

        Equipment::create([
            'equipment_type_id' => $coolingType->id,
            'reference' => 'CRAH/V1/BATT/B/02',
            'description' => 'DX type HIWALL UNIT',
            'area_served' => 'GROUND FLOOR BATTERY ROOM B',
            'manufacturer' => 'Toshiba',
            'warranty_expiry' => '2024-10-01',
        ]);

        Equipment::create([
            'equipment_type_id' => $coolingType->id,
            'reference' => 'CRAH/V1/BATT/B/03',
            'description' => 'DX type HIWALL UNIT',
            'area_served' => 'GROUND FLOOR BATTERY ROOM B',
            'manufacturer' => 'Toshiba',
            'warranty_expiry' => '2024-10-01',
        ]);

        Equipment::create([
            'equipment_type_id' => $coolingType->id,
            'reference' => 'IAC/V1/DH1/1',
            'description' => 'Indirect Adiabatic Cooling',
            'area_served' => 'Data Hall A',
            'manufacturer' => 'Excool',
            'cooling_capacity_kw' => 188,
            'warranty_expiry' => '2024-10-01',
        ]);

        Equipment::create([
            'equipment_type_id' => $coolingType->id,
            'reference' => 'IAC/V1/DH1/2',
            'description' => 'Indirect Adiabatic Cooling',
            'area_served' => 'Data Hall A',
            'manufacturer' => 'Excool',
            'cooling_capacity_kw' => 188,
            'warranty_expiry' => '2024-10-01',
        ]);

        Equipment::create([
            'equipment_type_id' => $coolingType->id,
            'reference' => 'FCU/V1/VRV/02',
            'description' => 'Cassette Split type',
            'area_served' => 'Reception',
        ]);

        Equipment::create([
            'equipment_type_id' => $coolingType->id,
            'reference' => 'FCU/V1/VRV/01',
            'description' => 'Cassette Split type',
            'area_served' => 'NOC',
        ]);

        Equipment::create([
            'equipment_type_id' => $coolingType->id,
            'description' => 'Cassette Split type',
            'area_served' => 'Boardroom',
        ]);

        Equipment::create([
            'equipment_type_id' => $coolingType->id,
            'description' => 'Cassette Split type',
            'area_served' => 'Server Room - Roof office',
        ]);

        Equipment::create([
            'equipment_type_id' => $coolingType->id,
            'reference' => 'MVHR/V1/01',
            'description' => 'Heat Recovery Unit',
            'area_served' => 'Loading Bay',
        ]);





















        // Insert power equipments
        Equipment::create([
            'equipment_type_id' => $powerType->id,
            'reference' => 'Gen/A1',
            'description' => 'Back up Power Generator 1.5MVA',
            'area_served' => 'Temporary for first phase back up power',
            'manufacturer' => 'Cummins',
            'warranty_expiry' => '2024-10-01',
        ]);

        Equipment::create([
            'equipment_type_id' => $powerType->id,
            'reference' => 'Gen/B1',
            'description' => 'Back up Power Generator 1.5MVA',
            'area_served' => 'Temporary for first phase back up power',
            'manufacturer' => 'Cummins',
            'warranty_expiry' => '2024-10-01',
        ]);

        Equipment::create([
            'equipment_type_id' => $powerType->id,
            'reference' => 'Gen A1/TX',
            'description' => '1600kVA Step up Transfomer',
            'area_served' => 'Step power from the 415V Generator voltage',
            'manufacturer' => 'Danish',
            'warranty_expiry' => '2028-10-01',
        ]);

        Equipment::create([
            'equipment_type_id' => $powerType->id,
            'reference' => 'Gen B1/TX',
            'description' => '1600kVA Step up Transfomer',
            'area_served' => 'Step power from the 415V Generator voltage',
            'manufacturer' => 'Danish',
            'warranty_expiry' => '2028-10-01',
        ]);

        Equipment::create([
            'equipment_type_id' => $powerType->id,
            'reference' => 'MV-PS-1-SW',
            'description' => 'Switchgear -Primary substation',
            'area_served' => 'KPLC Room receiving utility power from source A',
            'manufacturer' => 'Schneider Electric',
            'warranty_expiry' => '2024-10-01',
        ]);

        Equipment::create([
            'equipment_type_id' => $powerType->id,
            'reference' => 'MV-PS-2-SW',
            'description' => 'Switchgear -Primary substation',
            'area_served' => 'KPLC Room receiving utility power from source B',
            'manufacturer' => 'Schneider Electric',
            'warranty_expiry' => '2024-10-01',
        ]);

        Equipment::create([
            'equipment_type_id' => $powerType->id,
            'reference' => 'PS-1-TX-1',
            'description' => 'Step Down Transfomer 160kVA',
            'area_served' => 'In same room as primary switchgear to distribute power nearby',
            'manufacturer' => 'Schneider Electric - Trihal',
            'warranty_expiry' => '2028-10-01',
        ]);


        Equipment::create([
            'equipment_type_id' => $powerType->id,
            'reference' => 'PS-2-TX-2',
            'description' => 'Step Down Transfomer 160kVA',
            'area_served' => 'In same room as primary switchgear to distribute power nearby',
            'manufacturer' => 'Schneider Electric - Trihal',
            'warranty_expiry' => '2028-10-01',
        ]);

        Equipment::create([
            'equipment_type_id' => $powerType->id,
            'reference' => 'MV/PS/A/SW',
            'description' => 'Medium Voltage Primary Switchgear - 11kV',
            'area_served' => 'Medium Voltage Room A',
            'manufacturer' => 'Schneider Electric',
            'warranty_expiry' => '2024-10-01',
        ]);

        Equipment::create([
            'equipment_type_id' => $powerType->id,
            'reference' => 'MV/PS/B/SW',
            'description' => 'Medium Voltage Primary Switchgear - 11kV',
            'area_served' => 'Medium Voltage Room B',
            'manufacturer' => 'Schneider Electric',
            'warranty_expiry' => '2024-10-01',
        ]);

        Equipment::create([
            'equipment_type_id' => $powerType->id,
            'reference' => 'NET/A',
            'description' => 'Neutral Earthing Transformer 100kVA',
            'area_served' => 'Medium Voltage Room A for protection',
            'manufacturer' => 'Revive Electrical Transformers',
            'warranty_expiry' => '2028-10-01',
        ]);

        Equipment::create([
            'equipment_type_id' => $powerType->id,
            'reference' => 'NET/B',
            'description' => 'Neutral Earthing Transformer 100kVA',
            'area_served' => 'Medium Voltage Room B for protection',
            'manufacturer' => 'Revive Electrical Transformers',
            'warranty_expiry' => '2028-10-01',
        ]);

        Equipment::create([
            'equipment_type_id' => $powerType->id,
            'reference' => 'SD/VCB/A1',
            'description' => 'Premset switchgear',
            'area_served' => 'Input board from MV A board 1 before the Step down TX',
            'manufacturer' => 'Schneider Electric',
            'warranty_expiry' => '2024-10-01',
        ]);

        Equipment::create([
            'equipment_type_id' => $powerType->id,
            'reference' => 'SD/VCB/B1',
            'description' => 'Premset switchgear',
            'area_served' => 'Input board from MV B board 1 before the Step down TX',
            'manufacturer' => 'Schneider Electric',
            'warranty_expiry' => '2024-10-01',
        ]);

        Equipment::create([
            'equipment_type_id' => $powerType->id,
            'reference' => 'TX/A1',
            'description' => 'Transfomer 2.5MVA',
            'area_served' => 'Step Down Transformer for Stream A1',
            'manufacturer' => 'Schneider Electric - Trihal',
            'warranty_expiry' => '2028-10-01',
        ]);

        Equipment::create([
            'equipment_type_id' => $powerType->id,
            'reference' => 'TX/B1',
            'description' => 'Transformer 2.5MVA',
            'area_served' => 'Step Down Transformer for Stream B1',
            'manufacturer' => 'Schneider Electric - Trihal',
            'warranty_expiry' => '2028-10-01',
        ]);

        Equipment::create([
            'equipment_type_id' => $powerType->id,
            'reference' => 'SD/CB/V1/A1',
            'description' => 'Switchgear',
            'area_served' => 'Transfromer input board power stream A1',
            'manufacturer' => 'Schneider Electric',
            'warranty_expiry' => '2024-10-01',
        ]);

        Equipment::create([
            'equipment_type_id' => $powerType->id,
            'reference' => 'SD/CB/V1/B1',
            'description' => 'Switchgear',
            'area_served' => 'Transfromer input board power stream B1',
            'manufacturer' => 'Schneider Electric',
            'warranty_expiry' => '2024-10-01',
        ]);

        Equipment::create([
            'equipment_type_id' => $powerType->id,
            'reference' => 'UPS/INPUT/V1/A1',
            'description' => 'Switchgear',
            'area_served' => 'Input board from the TX input board power stream A1',
            'manufacturer' => 'Schneider Electric',
            'warranty_expiry' => '2024-10-01',
        ]);

        Equipment::create([
            'equipment_type_id' => $powerType->id,
            'reference' => 'UPS/INPUT/V1/B1',
            'description' => 'Switchgear',
            'area_served' => 'Input board from the TX input board power stream B1',
            'manufacturer' => 'Schneider Electric',
            'warranty_expiry' => '2024-10-01',
        ]);

        Equipment::create([
            'equipment_type_id' => $powerType->id,
            'reference' => 'UPS/V1/A1',
            'description' => 'UPS for power stream A1 - Galaxy VX 500kVA Scalable to 1000kVA',
            'manufacturer' => 'Schneider Electric',
            'warranty_expiry' => '2024-10-01',
        ]);

        Equipment::create([
            'equipment_type_id' => $powerType->id,
            'reference' => 'UPS/V1/B1',
            'description' => 'UPS for power stream B1- Galaxy VX 500kVA Scalable to 1000kVA',
            'manufacturer' => 'Schneider Electric',
            'warranty_expiry' => '2024-10-01',
        ]);

        Equipment::create([
            'equipment_type_id' => $powerType->id,
            'reference' => 'UPS/OUTPUT/V1/A1',
            'description' => 'Switchgear for output power from UPS A1',
            'manufacturer' => 'Schneider Electric',
            'warranty_expiry' => '2024-10-01',
        ]);

        Equipment::create([
            'equipment_type_id' => $powerType->id,
            'reference' => 'UPS/OUTPUT/V1/B1',
            'description' => 'Switchgear for output power from UPS B1',
            'manufacturer' => 'Schneider Electric',
            'warranty_expiry' => '2024-10-01',
        ]);

        Equipment::create([
            'equipment_type_id' => $powerType->id,
            'reference' => 'BATT/A1',
            'description' => 'Batteries for UPS A1',
            'manufacturer' => 'Schneider Electric (battery manufaturer is samsung)',
            'warranty_expiry' => '2024-10-01',
        ]);

        Equipment::create([
            'equipment_type_id' => $powerType->id,
            'reference' => 'BATT/B1',
            'description' => 'Batteries for UPS B1',
            'manufacturer' => 'Schneider Electric (battery manufaturer is samsung)',
            'warranty_expiry' => '2024-10-01',
        ]);

        // Insert security equipments
        Equipment::create([
            'equipment_type_id' => $securityType->id,
            'description' => 'Axis CCTV Cameras, Access control, switches and server',
            'manufacturer' => 'Axis',
            'warranty_expiry' => '2024-10-01',
        ]);

        Equipment::create([
            'equipment_type_id' => $securityType->id,
            'description' => 'Suprema biolite Biometric system',
            'manufacturer' => 'Suprema',
            'warranty_expiry' => '2024-10-01',
        ]);

        Equipment::create([
            'equipment_type_id' => $securityType->id,
            'description' => 'Intruder detection system',
            'manufacturer' => 'Prosys -Risco Group',
            'warranty_expiry' => '2024-10-01',
        ]);

        Equipment::create([
            'equipment_type_id' => $securityType->id,
            'description' => 'BOLLARDS',
            'manufacturer' => 'Ozak',
            'warranty_expiry' => '2024-10-01',
        ]);

        // Insert fire equipments
        Equipment::create([
            'equipment_type_id' => $fireType->id,
            'description' => 'Water Mist System',
            'manufacturer' => 'Danfoss - SEMSAFE',
            'warranty_expiry' => '2024-10-01',
        ]);

        Equipment::create([
            'equipment_type_id' => $fireType->id,
            'description' => 'HSSD',
            'manufacturer' => 'Air sense Stratos',
            'warranty_expiry' => '2024-10-01',
        ]);

        Equipment::create([
            'equipment_type_id' => $fireType->id,
            'description' => 'Fire Detection System',
            'manufacturer' => 'Carrier',
            'warranty_expiry' => '2024-10-01',
        ]);
    }
}
