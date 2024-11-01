<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Photo;
use App\Models\Asset;
use Faker\Factory as Faker;

class PhotoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();

        // Get all assets
        $assets = Asset::all();

        // Iterate through each asset and create a photo
        foreach ($assets as $asset) {
            Photo::create([
                'asset_id' => $asset->id,
                'filename' => $faker->word . '.jpg',
                'description' => $faker->sentence,
                'file_path' => 'path/to/photos/' . $faker->uuid . '.jpg',
            ]);
        }
    }
}
