<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\SparePartBatch;
use App\Models\SparePart;
use App\Models\SparePartTransaction;
use Illuminate\Database\Seeder;

class SparePartSeeder extends Seeder
{
    public function run()
    {
        // Create spare part batches
        $batches = [
            ['batch_number' => 'SPB001', 'manufacturing_date' => '2023-02-01', 'expiry_date' => '2025-01-31'],
            ['batch_number' => 'SPB002', 'manufacturing_date' => '2023-04-10', 'expiry_date' => '2026-04-09'],
        ];
        SparePartBatch::insert($batches);

        // Create spare parts
        $spareParts = [
            [
                'name' => 'Bearing',
                'description' => 'Ball bearing',
                'asset_id' => 1,
                'batch_id' => 1,
                'quantity_in_stock' => 20,
                'reorder_level' => 5,
                'storage_location' => 'Shelf A1',
            ],
            [
                'name' => 'Filter',
                'description' => 'Oil filter',
                'asset_id' => 2,
                'batch_id' => 2,
                'quantity_in_stock' => 15,
                'reorder_level' => 3,
                'storage_location' => 'Shelf B2',
            ],
        ];
        SparePart::insert($spareParts);

        // Create spare part transactions
        $transactions = [
            [
                'spare_part_id' => 1,
                'transaction_type' => 'Purchase',
                'quantity' => 20,
                'batch_id' => 1,
                'reference_number' => 'PO2001',
                'notes' => 'Initial purchase',
                'user_id' => 1,
            ],
            [
                'spare_part_id' => 2,
                'transaction_type' => 'Issue',
                'quantity' => 5,
                'batch_id' => 2,
                'reference_number' => 'WO2002',
                'notes' => 'Issued for replacement',
                'user_id' => 2,
            ],
        ];
        SparePartTransaction::insert($transactions);
    }
}
