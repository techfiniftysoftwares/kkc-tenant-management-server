<?php

namespace Database\Seeders;

use App\Models\Branch;
use App\Models\Building;
use App\Models\CommonArea;
use App\Models\Corridor;
use App\Models\Facility;
use App\Models\Floor;
use App\Models\Room;
use App\Models\Stair;
use Illuminate\Database\Seeder;
class FacilitySeeder extends Seeder
{
   /**
     * Run the database seeds.
     */
    public function run()
    {
        // Create facilities
        $facilities = Facility::factory()->count(5)->create();

        foreach ($facilities as $facility) {
            // Create branches for each facility
            $branches = Branch::factory()->count(rand(1, 3))->create([
                'facility_id' => $facility->id,
            ]);

            // Create buildings for each facility
            $buildings = Building::factory()->count(rand(1, 5))->create([
                'facility_id' => $facility->id,
            ]);

            foreach ($buildings as $building) {
                // Create floors for each building
                $floors = Floor::factory()->count(rand(1, 10))->create([
                    'building_id' => $building->id,
                ]);

                foreach ($floors as $floor) {
                    // Create rooms for each floor
                    $rooms = Room::factory()->count(rand(5, 20))->create([
                        'floor_id' => $floor->id,
                    ]);

                    // Create common areas for each floor
                    $commonAreas = CommonArea::factory()->count(rand(1, 3))->create([
                        'floor_id' => $floor->id,
                    ]);

                    // Create corridors for each floor
                    $corridors = Corridor::factory()->count(rand(1, 5))->create([
                        'floor_id' => $floor->id,
                    ]);
                }

                // Create stairs for each building
                $stairs = Stair::factory()->count(rand(1, 3))->create([
                    'building_id' => $building->id,
                    'floor_id' => $building->floors->random()->id,
                ]);
            }
        }
    }
}

