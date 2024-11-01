<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Building;
use App\Models\Branch;

class BuildingSeeder extends Seeder
{
    public function run()
    {
        $branches = Branch::all();

        foreach ($branches as $branch) {
            Building::factory()->count(3)->create([
                'branch_id' => $branch->id,
            ]);
        }
    }
}
