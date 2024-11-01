<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;
use App\Models\Asset;

class DepreciationRecordSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();

        $depreciationMethods = ['Straight Line', 'Declining Balance'];
        $valuationMethods = ['Market Value', 'Book Value'];

        for ($i = 1; $i <= 100; $i++) {
            // Fetch a random asset ID from the Asset model
            $asset = Asset::inRandomOrder()->first();
            $assetId = $asset->id;

            $depreciationMethod = $faker->randomElement($depreciationMethods);
            $depreciationRate = $faker->randomFloat(2, 1, 30);
            $depreciationPeriod = $faker->numberBetween(5, 20);
            $accumulatedDepreciation = $faker->randomFloat(2, 1000, 50000);
            $bookValue = $faker->randomFloat(2, 10000, 100000);
            $valuationMethod = $faker->randomElement($valuationMethods);
            $currentValue = $faker->randomFloat(2, 20000, 200000);
            $valuationDate = $faker->dateTimeBetween('-2 years', 'now')->format('Y-m-d');
            $remainingUsefulLife = $faker->numberBetween(1, 15);
            $salvageValue = $faker->randomFloat(2, 1000, 20000);
            $notes = $faker->optional()->sentence();

            DB::table('depreciation_records')->insert([
                'asset_id' => $assetId,
                'depreciation_method' => $depreciationMethod,
                'depreciation_rate' => $depreciationRate,
                'depreciation_period' => $depreciationPeriod,
                'accumulated_depreciation' => $accumulatedDepreciation,
                'book_value' => $bookValue,
                'valuation_method' => $valuationMethod,
                'current_value' => $currentValue,
                'valuation_date' => $valuationDate,
                'remaining_useful_life' => $remainingUsefulLife,
                'salvage_value' => $salvageValue,
                'notes' => $notes,
            ]);
        }
    }
}
