<?php

namespace Database\Seeders;

use App\Models\InventoryLog;
use Illuminate\Database\Seeder;

class InventoryLogsTableSeeder extends Seeder
{
    public function run()
    {
        InventoryLog::factory()->count(50)->create();
    }
}