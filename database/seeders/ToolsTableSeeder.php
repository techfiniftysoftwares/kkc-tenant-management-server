<?php

namespace Database\Seeders;

use App\Models\Tool;
use Illuminate\Database\Seeder;

class ToolsTableSeeder extends Seeder
{
    public function run()
    {
        Tool::factory()->count(20)->create();
    }
}
