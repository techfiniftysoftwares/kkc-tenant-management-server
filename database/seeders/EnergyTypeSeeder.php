<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EnergyTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
{
    DB::table('energy_types')->insert([
        ['name' => 'Diesel', 'unit' => 'L'],
        ['name' => 'Water', 'unit' => 'm³'],
        ['name' => 'Electricity', 'unit' => 'kWh'],
    ]);
}
}
