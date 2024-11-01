<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class LocationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $locations = [
            ['name' => 'Nairobi'],
            ['name' => 'Mombasa'],
            ['name' => 'Kisumu'],
            ['name' => 'Nakuru'],
            ['name' => 'Eldoret'],
            ['name' => 'Thika'],
            ['name' => 'Malindi'],
            ['name' => 'Kitale'],
            ['name' => 'Garissa'],
            ['name' => 'Kakamega'],
            ['name' => 'Kisii'],
            ['name' => 'Machakos'],
            ['name' => 'Naivasha'],
            ['name' => 'Meru'],
            ['name' => 'Nyeri'],
            ['name' => 'Lamu'],
            ['name' => 'Embu'],
            ['name' => 'Bungoma'],
            ['name' => 'Moyale'],
            ['name' => 'Isiolo'],
        ];
        
        
        

        // Insert asset types into the database
        foreach ($locations as $location) {
            \App\Models\Location::create($location);
        }
    }
}
