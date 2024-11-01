<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ToolCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */

        public function run()
        {
            $categories = [
                'Hand tools',
                'Power tools',
                'Precision tools',
                'Measuring and layout tools',
                'Cutting tools',
                'Fastening tools',
                'Striking tools',
                'Clamping tools',
                'Drilling and boring tools',
                'Electrical tools',
                'Plumbing tools',
                'HVAC tools',
                'Automotive tools',
                'Woodworking tools',
                'Metalworking tools',
                'Landscaping and gardening tools',
                'Painting tools',
                'Safety equipment',
                'Cleaning equipment',
                'Material handling tools',
                'Welding tools',
                'Diagnostic tools',
                'Lifting equipment',
                'Pneumatic tools',
                'Hydraulic tools',
            ];

            foreach ($categories as $category) {
                DB::table('tool_categories')->insert(['name' => $category]);
            }
        }


}
