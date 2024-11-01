<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Faker\Factory as Faker;

class UserSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create();

        // Define an array of existing email addresses
        $existingEmails = [
            'tonyodolo391@gmail.com',
            'luizezra@gmail.com',
            'joshujohn03@gmail.com',
            'mungaisam03@gmail.com',
            'gachirimwangi2021@gmail.com',
            'louangewemben@gmail.com',
        ];

        // Generate fake users
        for ($i = 0; $i < count($existingEmails); $i++) {
            // Randomly select a facility
            $facility = DB::table('facilities')->inRandomOrder()->first();

            // Fetch branches associated with the selected facility
            $branches = DB::table('branches')->where('facility_id', $facility->id)->get();

            // Check if branches exist for the facility
            if ($branches->isNotEmpty()) {
                // Randomly select a branch from the fetched branches
                $branch = $branches->random();

                // Fetch buildings associated with the selected branch
                $buildings = DB::table('buildings')->where('facility_id', $facility->id)->get();

                // Check if buildings exist for the branch
                if ($buildings->isNotEmpty()) {
                    // Randomly select a building from the fetched buildings
                    $building = $buildings->random();

                    // Fetch floors associated with the selected building
                    $floors = DB::table('floors')->where('building_id', $building->id)->get();

                    // Check if floors exist for the building
                    if ($floors->isNotEmpty()) {
                        // Randomly select a floor from the fetched floors
                        $floor = $floors->random();

                        // Fetch rooms associated with the selected floor
                        $rooms = DB::table('rooms')->where('floor_id', $floor->id)->get();

                        // Check if rooms exist for the floor
                        if ($rooms->isNotEmpty()) {
                            // Randomly select a room from the fetched rooms
                            $room = $rooms->random();

                            // Generate user data
                            $userData = [
                                'firstname' => $faker->firstName,
                                'lastname' => $faker->lastName,
                                'username' => $faker->userName,
                                'phone' => $faker->phoneNumber,
                                'position' => $faker->jobTitle,
                                'facility_id' => $facility->id,
                                'branch_id' => $branch->id,
                                'building_id' => $building->id,
                                'floor_id' => $floor->id,
                                'room_id' => $room->id,
                                'status' => $faker->randomElement(['active', 'inactive']),
                                'email' => $existingEmails[$i],
                                'password' => Hash::make('password'),
                                'login_attempts' => 0,
                                'created_at' => now(),
                                'updated_at' => now(),
                            ];

                            // Insert the user into the database
                            DB::table('users')->insert($userData);
                        }
                    }
                }
            }
        }
    }
}
