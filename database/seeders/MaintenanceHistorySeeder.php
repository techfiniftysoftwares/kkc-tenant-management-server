<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\MaintenanceHistory;
use App\Models\Asset;
use Faker\Factory as Faker;

class MaintenanceHistorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();

        // Get all asset IDs
        $assetIds = Asset::pluck('id')->toArray();

        // Define maintenance types
        $maintenanceTypes = ['Routine Check', 'Repair', 'Replacement', 'Cleaning'];

        // Create maintenance history records
        for ($i = 0; $i < 50; $i++) {
            MaintenanceHistory::create([
                'asset_id' => $faker->randomElement($assetIds),
                'maintenance_date' => $faker->dateTimeThisMonth(),
                'maintenance_type' => $faker->randomElement($maintenanceTypes),
                'notes' => $faker->sentence(),
            ]);
        }
    }
}

