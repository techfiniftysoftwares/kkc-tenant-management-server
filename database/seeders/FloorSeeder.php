<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class FloorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $floors = [];
        $buildingId = 1;

        // Loop through each building id
        for ($i = 1; $i <= 20; $i++) {
            // Generate random number of floors (between 1 and 5) for each building
            $numFloors = rand(1, 5);

            // Generate floors for the current building
            for ($j = 1; $j <= $numFloors; $j++) {
                $floors[] = [
                    'building_id' => $buildingId,
                    'floor_number' => $j,
                ];
            }

            $buildingId++; // Increment building id for the next iteration
        }

        // Insert data into the floors table
        foreach ($floors as $floor) {
            \App\Models\Floor::create($floor);
        }
    }
}
    