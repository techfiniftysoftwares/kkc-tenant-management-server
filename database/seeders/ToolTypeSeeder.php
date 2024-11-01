<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ToolTypeSeeder extends Seeder
{
    public function run()
    {
        $types = [
            'Hand tools' => ['Hammer', 'Screwdriver', 'Pliers', 'Wrench', 'Socket set', 'Allen key set', 'Hand saw', 'Measuring tape', 'Level', 'Utility knife', 'Chisel', 'File', 'Crowbar', 'Clamp'],
            'Power tools' => ['Drill', 'Circular saw', 'Reciprocating saw', 'Pressure washer', 'Air compressor', 'Grinder', 'Heat gun'],
            'Precision tools' => ['Multimeter', 'Wire stripper', 'Soldering iron'],
            'Measuring and layout tools' => ['Measuring tape', 'Level'],
            'Cutting tools' => ['Hand saw', 'Circular saw', 'Reciprocating saw', 'Utility knife'],
            'Fastening tools' => ['Screwdriver', 'Wrench', 'Socket set', 'Allen key set', 'Torque wrench'],
            'Striking tools' => ['Hammer', 'Chisel'],
            'Clamping tools' => ['Clamp'],
            'Drilling and boring tools' => ['Drill'],
            'Electrical tools' => ['Multimeter', 'Wire stripper', 'Soldering iron'],
            'Plumbing tools' => ['Pipe wrench'],
            'HVAC tools' => [],
            'Automotive tools' => ['Torque wrench'],
            'Woodworking tools' => ['Hand saw', 'Circular saw', 'Reciprocating saw', 'Chisel', 'File', 'Clamp'],
            'Metalworking tools' => ['Grinder'],
            'Landscaping and gardening tools' => ['Ladder'],
            'Painting tools' => [],
            'Safety equipment' => [],
            'Cleaning equipment' => ['Pressure washer'],
            'Material handling tools' => ['Ladder'],
            'Welding tools' => [],
            'Diagnostic tools' => ['Multimeter'],
            'Lifting equipment' => ['Ladder'],
            'Pneumatic tools' => ['Air compressor'],
            'Hydraulic tools' => [],
        ];

        foreach ($types as $category => $toolTypes) {
            $categoryId = DB::table('tool_categories')->where('name', $category)->value('id');
            foreach ($toolTypes as $type) {
                DB::table('tool_types')->updateOrInsert(
                    ['name' => $type],
                    ['category_id' => $categoryId]
                );
            }
        }
    }
}
