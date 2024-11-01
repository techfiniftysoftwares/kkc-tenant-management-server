<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EnergyConsumptionLocationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
{
    DB::table('energy_consumption_locations')->insert([
        ['name' => 'Service Line A'],
        ['name' => 'Service Line B'],
        ['name' => 'Service Line C'],
        ['name' => 'Operations'],
        ['name' => 'Offices'],
    ]);
}
}
