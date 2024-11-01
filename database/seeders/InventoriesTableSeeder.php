<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;


class InventoriesTableSeeder extends Seeder
{

    public function run()
    {
        // Spare Parts
        DB::table('spare_parts')->insert([
            ['part_name' => 'HVAC Filter', 'asset_id' => 16, 'is_consumable' => true, 'reorder_level' => 100, 'reorder_threshold' => 50, 'average_consumption' => 10, 'lead_time' => 7],
            ['part_name' => ' Hvac Chiller Compressor', 'asset_id' => 19, 'is_consumable' => false, 'reorder_level' => 2, 'reorder_threshold' => 1, 'average_consumption' => 0.1, 'lead_time' => 30],
            ['part_name' => 'Hvac Boiler Valve', 'asset_id' => 18, 'is_consumable' => false, 'reorder_level' => 5, 'reorder_threshold' => 2, 'average_consumption' => 0.5, 'lead_time' => 14],
            ['part_name' => 'Hvac Insulation Duct', 'asset_id' => 17, 'is_consumable' => false, 'reorder_level' => 3, 'reorder_threshold' => 1, 'average_consumption' => 0.2, 'lead_time' => 21],
            ['part_name' => 'HVAC Refrigerant', 'asset_id' => 20, 'is_consumable' => true, 'reorder_level' => 20, 'reorder_threshold' => 10, 'average_consumption' => 5, 'lead_time' => 7],
        ]);

        // Consumable Categories
        DB::table('consumable_categories')->insert([
            ['category_name' => 'Cleaning Supplies'],
            ['category_name' => 'Office Supplies'],
            ['category_name' => 'Safety Equipment'],
        ]);

        // Consumables
        DB::table('consumables')->insert([
            ['consumable_name' => 'All-Purpose Cleaner', 'category_id' => 1, 'reorder_level' => 50, 'reorder_threshold' => 20, 'average_consumption' => 15, 'lead_time' => 5],
            ['consumable_name' => 'Printer Paper', 'category_id' => 2, 'reorder_level' => 100, 'reorder_threshold' => 50, 'average_consumption' => 30, 'lead_time' => 3],
            ['consumable_name' => 'Safety Gloves', 'category_id' => 3, 'reorder_level' => 200, 'reorder_threshold' => 100, 'average_consumption' => 50, 'lead_time' => 7],
        ]);

        // Unit Conversions
        DB::table('unit_conversions')->insert([
            ['item_type' => 'spare_part', 'item_id' => 1, 'bulk_unit' => 'box', 'dispatch_unit' => 'piece', 'last_known_factor' => 50, 'last_update_date' => '2023-01-01'],
            ['item_type' => 'spare_part', 'item_id' => 2, 'bulk_unit' => 'pallet', 'dispatch_unit' => 'piece', 'last_known_factor' => 10, 'last_update_date' => '2023-02-15'],
            ['item_type' => 'consumable', 'item_id' => 1, 'bulk_unit' => 'case', 'dispatch_unit' => 'bottle', 'last_known_factor' => 12, 'last_update_date' => '2023-03-10'],
            ['item_type' => 'consumable', 'item_id' => 2, 'bulk_unit' => 'carton', 'dispatch_unit' => 'ream', 'last_known_factor' => 10, 'last_update_date' => '2023-04-05'],
        ]);

        // Bulk Quantity History
        DB::table('bulk_quantity_history')->insert([
            ['item_type' => 'spare_part', 'item_id' => 1, 'bulk_unit' => 'box', 'quantity_per_bulk' => 50, 'effective_date' => '2023-01-01'],
            ['item_type' => 'spare_part', 'item_id' => 1, 'bulk_unit' => 'box', 'quantity_per_bulk' => 60, 'effective_date' => '2023-03-15'],
            ['item_type' => 'consumable', 'item_id' => 1, 'bulk_unit' => 'case', 'quantity_per_bulk' => 12, 'effective_date' => '2023-03-10'],
            ['item_type' => 'consumable', 'item_id' => 1, 'bulk_unit' => 'case', 'quantity_per_bulk' => 15, 'effective_date' => '2023-05-20'],
        ]);

        // Inventory Batches
        DB::table('inventory_batches')->insert([
            ['item_type' => 'spare_part', 'item_id' => 1, 'purchase_date' => '2023-01-01', 'quantity' => 100, 'unit_price' => 5.99, 'supplier' => 'HVAC Supplies Inc.', 'unit_type' => 'dispatch', 'quantity_per_bulk' => 1],
            ['item_type' => 'spare_part', 'item_id' => 1, 'purchase_date' => '2023-02-15', 'quantity' => 5, 'unit_price' => 299.50, 'supplier' => 'HVAC Supplies Inc.', 'unit_type' => 'bulk', 'quantity_per_bulk' => 50],
            ['item_type' => 'spare_part', 'item_id' => 2, 'purchase_date' => '2023-03-10', 'quantity' => 1, 'unit_price' => 2500.00, 'supplier' => 'Chiller Parts Ltd.', 'unit_type' => 'dispatch', 'quantity_per_bulk' => 1],
            ['item_type' => 'consumable', 'item_id' => 1, 'purchase_date' => '2023-04-05', 'quantity' => 10, 'unit_price' => 119.88, 'supplier' => 'Cleaning Supplies Co.', 'unit_type' => 'bulk', 'quantity_per_bulk' => 12],
            ['item_type' => 'consumable', 'item_id' => 2, 'purchase_date' => '2023-05-20', 'quantity' => 20, 'unit_price' => 24.99, 'supplier' => 'Office Supplies Ltd.', 'unit_type' => 'dispatch', 'quantity_per_bulk' => 1],
        ]);

        // Current Inventory
        DB::table('current_inventory')->insert([
            ['item_type' => 'spare_part', 'item_id' => 1, 'quantity_bulk' => 5, 'quantity_dispatch' => 80, 'average_cost_bulk' => 299.50, 'average_cost_dispatch' => 5.99],
            ['item_type' => 'spare_part', 'item_id' => 2, 'quantity_bulk' => 0, 'quantity_dispatch' => 1, 'average_cost_bulk' => 0, 'average_cost_dispatch' => 2500.00],
            ['item_type' => 'consumable', 'item_id' => 1, 'quantity_bulk' => 10, 'quantity_dispatch' => 108, 'average_cost_bulk' => 119.88, 'average_cost_dispatch' => 9.99],
            ['item_type' => 'consumable', 'item_id' => 2, 'quantity_bulk' => 0, 'quantity_dispatch' => 200, 'average_cost_bulk' => 0, 'average_cost_dispatch' => 24.99],
        ]);
    }
}
