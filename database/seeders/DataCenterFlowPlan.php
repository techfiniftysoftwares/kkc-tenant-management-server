<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Building;
use App\Models\Floor;
use App\Models\Room;

class DataCenterFlowPlan extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        // Create the building record
        $building = Building::create([
            'name' => 'IX HQ',
            'location_id' => 1,
        ]);

        // Ground Floor
        $groundFloor = Floor::create([
            'building_id' => $building->id,
            'floor_number' => 'Ground Floor',
        ]);

        $rooms = [
            ['room_number' => 'GF-ENT-001', 'name' => 'Main Entrance and Reception Area', 'description' => 'Entry point and reception for visitors and staff'],
            ['room_number' => 'GF-SEC-002', 'name' => 'Security Office and Access Control', 'description' => 'Security monitoring and access control systems'],
            ['room_number' => 'GF-LDG-003', 'name' => 'Loading Docks and Receiving Area', 'description' => 'Area for receiving and shipping equipment and supplies'],
            ['room_number' => 'GF-STR-004', 'name' => 'Storage and Inventory Room', 'description' => 'Storage space for equipment and inventory management'],
            ['room_number' => 'GF-GEN-005', 'name' => 'Generator Room', 'description' => 'Houses backup generators for power outages'],
            ['room_number' => 'GF-UPS-006', 'name' => 'Uninterruptible Power Supply (UPS) Room', 'description' => 'Houses UPS systems for clean and uninterrupted power'],
            ['room_number' => 'GF-ELC-007', 'name' => 'Electrical Distribution Room', 'description' => 'Distributes electrical power throughout the facility'],
            ['room_number' => 'GF-MEC-008', 'name' => 'Mechanical Room (HVAC, Cooling Systems)', 'description' => 'Houses HVAC and cooling systems for temperature control'],
            ['room_number' => 'GF-FIR-009', 'name' => 'Fire Suppression Room', 'description' => 'Contains fire suppression equipment and systems'],
            ['room_number' => 'GF-TEL-010', 'name' => 'Telecommunications Room', 'description' => 'Houses telecommunications equipment and connections'],
            ['room_number' => 'GF-NOC-011', 'name' => 'Network Operations Center (NOC)', 'description' => 'Monitoring and management of network operations'],
            ['room_number' => 'GF-BRK-012', 'name' => 'Break Room and Restrooms', 'description' => 'Area for staff breaks and restroom facilities'],
        ];

        $this->createRooms($rooms, $groundFloor);

        // First Floor
        $firstFloor = Floor::create([
            'building_id' => $building->id,
            'floor_number' => 'First Floor',
        ]);

        $rooms = [
            ['room_number' => 'F1-DH1-013', 'name' => 'Data Hall 1', 'description' => 'Server racks, cabinets, and cages'],
            ['room_number' => 'F1-DH2-014', 'name' => 'Data Hall 2', 'description' => 'Server racks, cabinets, and cages'],
            ['room_number' => 'F1-DH3-015', 'name' => 'Data Hall 3', 'description' => 'Server racks, cabinets, and cages'],
            ['room_number' => 'F1-STG-016', 'name' => 'Staging and Burn-in Area', 'description' => 'Area for assembling and testing equipment before deployment'],
            ['room_number' => 'F1-STO-017', 'name' => 'Parts Storage and Spares Room', 'description' => 'Storage for spare parts and components'],
            ['room_number' => 'F1-ELC-018', 'name' => 'Electrical Distribution Room', 'description' => 'Distributes electrical power throughout the floor'],
            ['room_number' => 'F1-MEC-019', 'name' => 'Mechanical Room (HVAC, Cooling Systems)', 'description' => 'Houses HVAC and cooling systems for temperature control'],
            ['room_number' => 'F1-FIR-020', 'name' => 'Fire Suppression Room', 'description' => 'Contains fire suppression equipment and systems'],
            ['room_number' => 'F1-TEL-021', 'name' => 'Telecommunications Room', 'description' => 'Houses telecommunications equipment and connections'],
            ['room_number' => 'F1-MTG-022', 'name' => 'Meeting Rooms and Collaboration Spaces', 'description' => 'Areas for staff meetings and collaboration'],
            ['room_number' => 'F1-BRK-023', 'name' => 'Break Room and Restrooms', 'description' => 'Area for staff breaks and restroom facilities'],
        ];

        $this->createRooms($rooms, $firstFloor);

        // Second Floor
        $secondFloor = Floor::create([
            'building_id' => $building->id,
            'floor_number' => 'Second Floor',
        ]);

        $rooms = [
            ['room_number' => 'F2-DH4-024', 'name' => 'Data Hall 4', 'description' => 'Server racks, cabinets, and cages'],
            ['room_number' => 'F2-DH5-025', 'name' => 'Data Hall 5', 'description' => 'Server racks, cabinets, and cages'],
            ['room_number' => 'F2-DH6-026', 'name' => 'Data Hall 6', 'description' => 'Server racks, cabinets, and cages'],
            ['room_number' => 'F2-ELC-027', 'name' => 'Electrical Distribution Room', 'description' => 'Distributes electrical power throughout the floor'],
            ['room_number' => 'F2-MEC-028', 'name' => 'Mechanical Room (HVAC, Cooling Systems)', 'description' => 'Houses HVAC and cooling systems for temperature control'],
            ['room_number' => 'F2-FIR-029', 'name' => 'Fire Suppression Room', 'description' => 'Contains fire suppression equipment and systems'],
            ['room_number' => 'F2-TEL-030', 'name' => 'Telecommunications Room', 'description' => 'Houses telecommunications equipment and connections'],
            ['room_number' => 'F2-OFF-031', 'name' => 'Staff Offices', 'description' => 'Offices for data center staff and management'],
            ['room_number' => 'F2-CNF-032', 'name' => 'Conference Rooms', 'description' => 'Rooms for meetings and conferences'],
            ['room_number' => 'F2-BRK-033', 'name' => 'Break Room and Restrooms', 'description' => 'Area for staff breaks and restroom facilities'],
        ];

        $this->createRooms($rooms, $secondFloor);

        // Third Floor
        $thirdFloor = Floor::create([
            'building_id' => $building->id,
            'floor_number' => 'Third Floor',
        ]);

        $rooms = [
            ['room_number' => 'F3-EXC-034', 'name' => 'Executive Offices', 'description' => 'Offices for executive management'],
            ['room_number' => 'F3-HRD-035', 'name' => 'Human Resources Department', 'description' => 'HR offices for staff management and support'],
            ['room_number' => 'F3-FIN-036', 'name' => 'Finance Department', 'description' => 'Offices for financial management and accounting'],
            ['room_number' => 'F3-MKT-037', 'name' => 'Marketing and Sales Department', 'description' => 'Offices for marketing and sales teams'],
            ['room_number' => 'F3-TRN-038', 'name' => 'Training and Certification Center', 'description' => 'Area for staff training and certification programs'],
            ['room_number' => 'F3-CNF-039', 'name' => 'Conference Rooms', 'description' => 'Rooms for meetings and conferences'],
            ['room_number' => 'F3-BRK-040', 'name' => 'Break Room and Restrooms', 'description' => 'Area for staff breaks and restroom facilities'],
            ['room_number' => 'F3-ELC-041', 'name' => 'Electrical Distribution Room', 'description' => 'Distributes electrical power throughout the floor'],
            ['room_number' => 'F3-MEC-042', 'name' => 'Mechanical Room (HVAC)', 'description' => 'Houses HVAC systems for temperature control'],
        ];

        $this->createRooms($rooms, $thirdFloor);

        // Rooftop
        $rooftop = Floor::create([
            'building_id' => $building->id,
            'floor_number' => 'Fourth Floor',
        ]);

        $rooms = [
            ['room_number' => 'RF-TER-043', 'name' => 'Rooftop Terrace', 'description' => 'Outdoor space for staff breaks and events'],
            ['room_number' => 'RF-CLT-044', 'name' => 'Cooling Towers', 'description' => 'Cooling systems for heat rejection from the facility'],
            ['room_number' => 'RF-SOL-045', 'name' => 'Solar Panels', 'description' => 'Photovoltaic panels for renewable energy generation'],
            ['room_number' => 'RF-MEC-046', 'name' => 'Rooftop Mechanical Room', 'description' => 'Houses mechanical equipment for rooftop systems'],
            ['room_number' => 'RF-ANT-047', 'name' => 'Telecommunications Antennas', 'description' => 'Antennas for wireless communication and connectivity'],
        ];

        $this->createRooms($rooms, $rooftop);
    }

    private function createRooms($rooms, $floor)
    {
        foreach ($rooms as $roomData) {
            Room::create([
                'floor_id' => $floor->id,
                'room_number' => $roomData['room_number'],
                'name' => $roomData['name'],
                'description' => $roomData['description'],
            ]);
        }
    }
}

