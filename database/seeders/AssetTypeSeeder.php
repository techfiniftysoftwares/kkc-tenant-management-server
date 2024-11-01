<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AssetTypeSeeder extends Seeder
{
    public function run(): void
    {
        $assetTypes = [
            ['name' => 'Computer', 'description' => 'Desktop or laptop computers'],
            ['name' => 'Furniture', 'description' => 'Office furniture like desks and chairs'],
            ['name' => 'Vehicle', 'description' => 'Company cars and trucks'],
            ['name' => 'Software', 'description' => 'Licensed software applications'],
            ['name' => 'Network Equipment', 'description' => 'Routers, switches, and other network devices'],
            ['name' => 'Mobile Device', 'description' => 'Smartphones and tablets'],
            ['name' => 'Printer', 'description' => 'Office printers and multi-function devices'],
            ['name' => 'Server', 'description' => 'Physical and virtual servers'],
            ['name' => 'Audio/Visual Equipment', 'description' => 'Projectors, cameras, and sound systems'],
            ['name' => 'Office Supplies', 'description' => 'Consumable office items']
        ];

        foreach ($assetTypes as $assetType) {
            DB::table('asset_types')->insert($assetType);
        }
    }
}