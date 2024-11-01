<?php
namespace Database\Seeders;
use Illuminate\Database\Seeder;
use App\Models\Asset;
use App\Models\Room;

class AssetRoomSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Retrieve all rooms
        $rooms = Room::all();

        // Populate room_id for each asset
        Asset::all()->each(function ($asset) use ($rooms) {
            // Attach a random room to the asset
            $asset->update(['room_id' => $rooms->random()->id]);
        });
    }
}
