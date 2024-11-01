<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Asset;
use App\Models\Document;
use Faker\Factory as Faker;

class DocumentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Create Faker instance
        $faker = Faker::create();

        // Get all assets
        $assets = Asset::all();

        // Seed documents for each asset
        foreach ($assets as $asset) {
            Document::create([
                'asset_id' => $asset->id,
                'filename' => $faker->word . '.pdf',
                'description' => $faker->sentence,
                'file_path' => '/path/to/' . $faker->word . '.pdf',
            ]);
        }
    }
}
