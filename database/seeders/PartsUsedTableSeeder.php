<?php

namespace Database\Seeders;

use App\Models\PartsUsed;
use Illuminate\Database\Seeder;

class PartsUsedTableSeeder extends Seeder
{
    public function run()
    {
        PartsUsed::factory()->count(50)->create();
    }
}