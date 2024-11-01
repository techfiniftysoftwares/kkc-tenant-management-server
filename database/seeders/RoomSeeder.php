<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Room;
use App\Models\Floor;

class RoomSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Get all floors
        $floors = Floor::all();

        // Define the number of rooms per floor
        $roomsPerFloor = [2, 3]; // For example, 2 to 3 rooms per floor

        // Iterate through each floor
        foreach ($floors as $floor) {
            // Generate a random number of rooms for the current floor
            $numRooms = rand($roomsPerFloor[0], $roomsPerFloor[1]);

            // Create rooms for the current floor
            for ($i = 1; $i <= $numRooms; $i++) {
                // Create a new room with floor_id and a unique room_number
                Room::create([
                    'floor_id' => $floor->id,
                    'room_number' => $i,
                    // Add other attributes as needed
                ]);
            }
        }
    }
}

