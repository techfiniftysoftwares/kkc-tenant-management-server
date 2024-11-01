<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\EnergyConsumption;
use App\Models\EnergyConsumptionLocation;
use App\Models\EnergyType;
use DateInterval;
use DatePeriod;
use DateTime;

class EnergyConsumptionSeeder extends Seeder
{
    public function run()
    {
        $locations = [1, 2, 3, 4, 5]; // List of available location IDs
        $consumptions = [];
        $startDate = '2023-06-01'; // Start date
        $endDate = '2023-06-20'; // End date

        $currentDate = new DateTime($startDate);
        $dateInterval = new DateInterval('P1D'); // 1 day interval
        $periodInterval = new DateInterval('P3D'); // 3 day interval

        $period = new DatePeriod(new DateTime($startDate), $periodInterval, new DateTime($endDate));

        foreach ($period as $dt) {
            for ($i = 0; $i < 3; $i++) {
                $consumptions[] = [
                    'date' => $currentDate->format('Y-m-d'), // Use the same date for each set of three records
                    'energy_type_id' => rand(1, 3), // Randomly assign energy type ID
                    'energy_consumption_location_id' => $locations[array_rand($locations)], // Randomly assign location ID
                    'consumption' => rand(500, 3000), // Random consumption value between 500 and 3000
                    'price' => round(rand(10, 30) + rand(0, 99) / 100, 2), // Random price between 10 and 30 with two decimal places
                ];
                $currentDate->add($dateInterval);
            }
        }

        foreach ($consumptions as $consumption) {
            EnergyConsumption::create($consumption);
        }
    }
}
