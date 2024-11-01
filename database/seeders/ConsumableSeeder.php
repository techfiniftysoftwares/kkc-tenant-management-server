<?php

namespace Database\Seeders;

use App\Models\Consumable;
use App\Models\ConsumableCategory;
use App\Models\ConsumableBatches;
use App\Models\ConsumableTransaction;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class ConsumableSeeder extends Seeder
{
    public function run()
    {
        // Create consumable categories
        $categories = [
            ['name' => 'Electrical', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Plumbing', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Cleaning', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Office Supplies', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Safety Equipment', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'HVAC', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Painting', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Carpentry', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Welding', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Landscaping', 'created_at' => now(), 'updated_at' => now()],
        ];
        ConsumableCategory::insert($categories);

        // Create consumables with batches
        $consumablesWithBatches = [
            [
                'name' => 'LED Light Bulb',
                'description' => 'Energy-efficient LED light bulb',
                'category_id' => 1,
                'manufacturer' => 'Philips',
                'supplier' => 'Electrical Supplies Inc.',
                'quantity_in_stock' => 1000,
                'reorder_level' => 200,
                'unit_price' => 4.99,
                'created_at' => now(),
                'updated_at' => now(),
                'batches' => [
                    ['batch_number' => 'B001-001', 'manufacturing_date' => '2023-01-01', 'expiry_date' => '2025-12-31', 'created_at' => now(), 'updated_at' => now()],
                    ['batch_number' => 'B001-002', 'manufacturing_date' => '2023-03-15', 'expiry_date' => '2026-03-14', 'created_at' => now(), 'updated_at' => now()],
                    ['batch_number' => 'B001-003', 'manufacturing_date' => '2023-05-01', 'expiry_date' => '2026-04-30', 'created_at' => now(), 'updated_at' => now()],
                ],
                'transactions' => [
                    ['transaction_type' => 'purchase', 'quantity' => 500, 'unit_price' => 4.99, 'transaction_date' => now()->subMonths(3), 'created_at' => now()->subMonths(3), 'updated_at' => now()->subMonths(3)],
                    ['transaction_type' => 'purchase', 'quantity' => 300, 'unit_price' => 4.99, 'transaction_date' => now()->subMonths(2), 'created_at' => now()->subMonths(2), 'updated_at' => now()->subMonths(2)],
                    ['transaction_type' => 'purchase', 'quantity' => 200, 'unit_price' => 4.99, 'transaction_date' => now()->subMonth(), 'created_at' => now()->subMonth(), 'updated_at' => now()->subMonth()],
                    ['transaction_type' => 'issue', 'quantity' => 50, 'maintenance_id' => 1, 'transaction_date' => now(), 'created_at' => now(), 'updated_at' => now()],
                ],
            ],
            [
                'name' => 'PVC Pipe',
                'description' => '1/2 inch PVC pipe',
                'category_id' => 2,
                'manufacturer' => 'Advanced Drainage Systems',
                'supplier' => 'Plumbing Wholesale',
                'quantity_in_stock' => 2000,
                'reorder_level' => 500,
                'unit_price' => 1.99,
                'created_at' => now(),
                'updated_at' => now(),
                'batches' => [
                    ['batch_number' => 'B002-001', 'manufacturing_date' => '2023-02-01', 'expiry_date' => '2028-01-31', 'created_at' => now(), 'updated_at' => now()],
                    ['batch_number' => 'B002-002', 'manufacturing_date' => '2023-04-15', 'expiry_date' => '2028-04-14', 'created_at' => now(), 'updated_at' => now()],
                ],
                'transactions' => [
                    ['transaction_type' => 'purchase', 'quantity' => 1000, 'unit_price' => 1.99, 'transaction_date' => now()->subMonths(4), 'created_at' => now()->subMonths(4), 'updated_at' => now()->subMonths(4)],
                    ['transaction_type' => 'purchase', 'quantity' => 1000, 'unit_price' => 1.99, 'transaction_date' => now()->subMonths(2), 'created_at' => now()->subMonths(2), 'updated_at' => now()->subMonths(2)],
                    ['transaction_type' => 'issue', 'quantity' => 100, 'maintenance_id' => 2, 'transaction_date' => now()->subWeek(), 'created_at' => now()->subWeek(), 'updated_at' => now()->subWeek()],
                ],
            ],
            [
                'name' => 'Disposable Gloves',
                'description' => 'Latex disposable gloves',
                'category_id' => 3,
                'manufacturer' => 'Kimberly-Clark',
                'supplier' => 'Janitorial Supply Co.',
                'quantity_in_stock' => 5000,
                'reorder_level' => 1000,
                'unit_price' => 0.25,
                'created_at' => now(),
                'updated_at' => now(),
                'batches' => [
                    ['batch_number' => 'B003-001', 'manufacturing_date' => '2023-01-01', 'expiry_date' => '2024-12-31', 'created_at' => now(), 'updated_at' => now()],
                    ['batch_number' => 'B003-002', 'manufacturing_date' => '2023-03-15', 'expiry_date' => '2025-03-14', 'created_at' => now(), 'updated_at' => now()],
                    ['batch_number' => 'B003-003', 'manufacturing_date' => '2023-06-01', 'expiry_date' => '2025-05-31', 'created_at' => now(), 'updated_at' => now()],
                ],
                'transactions' => [
                    ['transaction_type' => 'purchase', 'quantity' => 2000, 'unit_price' => 0.25, 'transaction_date' => now()->subMonths(5), 'created_at' => now()->subMonths(5), 'updated_at' => now()->subMonths(5)],
                    ['transaction_type' => 'purchase', 'quantity' => 2000, 'unit_price' => 0.25, 'transaction_date' => now()->subMonths(3), 'created_at' => now()->subMonths(3), 'updated_at' => now()->subMonths(3)],
                    ['transaction_type' => 'purchase', 'quantity' => 1000, 'unit_price' => 0.25, 'transaction_date' => now()->subMonth(), 'created_at' => now()->subMonth(), 'updated_at' => now()->subMonth()],
                    ['transaction_type' => 'issue', 'quantity' => 500, 'maintenance_id' => 3, 'transaction_date' => now()->subDays(3), 'created_at' => now()->subDays(3), 'updated_at' => now()->subDays(3)],
                ],
            ],
            [
                'name' => 'Air Filter',
                'description' => 'HVAC air filter',
                'category_id' => 6,
                'manufacturer' => 'Filtrete',
                'supplier' => 'HVAC Supplies Inc.',
                'quantity_in_stock' => 500,
                'reorder_level' => 100,
                'unit_price' => 7.99,
                'created_at' => now(),
                'updated_at' => now(),
                'batches' => [
                    ['batch_number' => 'B004-001', 'manufacturing_date' => '2023-01-01', 'expiry_date' => '2024-12-31', 'created_at' => now(), 'updated_at' => now()],
                    ['batch_number' => 'B004-002', 'manufacturing_date' => '2023-04-01', 'expiry_date' => '2025-03-31', 'created_at' => now(), 'updated_at' => now()],
                ],
                'transactions' => [
                    ['transaction_type' => 'purchase', 'quantity' => 300, 'unit_price' => 7.99, 'transaction_date' => now()->subMonths(4), 'created_at' => now()->subMonths(4), 'updated_at' => now()->subMonths(4)],
                    ['transaction_type' => 'purchase', 'quantity' => 200, 'unit_price' => 7.99, 'transaction_date' => now()->subMonths(2), 'created_at' => now()->subMonths(2), 'updated_at' => now()->subMonths(2)],
                    ['transaction_type' => 'issue', 'quantity' => 50, 'maintenance_id' => 4, 'transaction_date' => now()->subWeek(), 'created_at' => now()->subWeek(), 'updated_at' => now()->subWeek()],
                ],
            ],
            [
                'name' => 'Paint Brush',
                'description' => '2 inch paint brush',
                'category_id' => 7,
                'manufacturer' => 'Purdy',
                'supplier' => 'Paint Supply Warehouse',
                'quantity_in_stock' => 200,
                'reorder_level' => 50,
                'unit_price' => 3.99,
                'created_at' => now(),
                'updated_at' => now(),
                'batches' => [
                    ['batch_number' => 'B005-001', 'manufacturing_date' => '2023-02-01', 'expiry_date' => '2028-01-31', 'created_at' => now(), 'updated_at' => now()],
                    ['batch_number' => 'B005-002', 'manufacturing_date' => '2023-05-01', 'expiry_date' => '2028-04-30', 'created_at' => now(), 'updated_at' => now()],
                ],
                'transactions' => [
                    ['transaction_type' => 'purchase', 'quantity' => 100, 'unit_price' => 3.99, 'transaction_date' => now()->subMonths(5), 'created_at' => now()->subMonths(5), 'updated_at' => now()->subMonths(5)],
                    ['transaction_type' => 'purchase', 'quantity' => 100, 'unit_price' => 3.99, 'transaction_date' => now()->subMonths(2), 'created_at' => now()->subMonths(2), 'updated_at' => now()->subMonths(2)],
                    ['transaction_type' => 'issue', 'quantity' => 20, 'maintenance_id' => 5, 'transaction_date' => now()->subDays(2), 'created_at' => now()->subDays(2), 'updated_at' => now()->subDays(2)],
                ],
            ],
            [
                'name' => 'Wood Screw',
                'description' => '#8 x 2 inch wood screw',
                'category_id' => 8,
                'manufacturer' => 'GRK Fasteners',
                'supplier' => 'Woodworking Supply Co.',
                'quantity_in_stock' => 1000,
                'reorder_level' => 200,
                'unit_price' => 0.15,
                'created_at' => now(),
                'updated_at' => now(),
                'batches' => [
                    ['batch_number' => 'B006-001', 'manufacturing_date' => '2023-01-01', 'expiry_date' => '2027-12-31', 'created_at' => now(), 'updated_at' => now()],
                    ['batch_number' => 'B006-002', 'manufacturing_date' => '2023-03-15', 'expiry_date' => '2028-03-14', 'created_at' => now(), 'updated_at' => now()],
                    ['batch_number' => 'B006-003', 'manufacturing_date' => '2023-06-01', 'expiry_date' => '2028-05-31', 'created_at' => now(), 'updated_at' => now()],
                ],
                'transactions' => [
                    ['transaction_type' => 'purchase', 'quantity' => 500, 'unit_price' => 0.15, 'transaction_date' => now()->subMonths(6), 'created_at' => now()->subMonths(6), 'updated_at' => now()->subMonths(6)],
                    ['transaction_type' => 'purchase', 'quantity' => 500, 'unit_price' => 0.15, 'transaction_date' => now()->subMonths(3), 'created_at' => now()->subMonths(3), 'updated_at' => now()->subMonths(3)],
                    ['transaction_type' => 'issue', 'quantity' => 100, 'maintenance_id' => 6, 'transaction_date' => now()->subWeek(), 'created_at' => now()->subWeek(), 'updated_at' => now()->subWeek()],
                ],
            ],
            [
                'name' => 'Welding Rod',
                'description' => 'E6013 welding rod',
                'category_id' => 9,
                'manufacturer' => 'Lincoln Electric',
                'supplier' => 'Welding Supplies Inc.',
                'quantity_in_stock' => 500,
                'reorder_level' => 100,
                'unit_price' => 1.25,
                'created_at' => now(),
                'updated_at' => now(),
                'batches' => [
                    ['batch_number' => 'B007-001', 'manufacturing_date' => '2023-02-01', 'expiry_date' => '2025-01-31', 'created_at' => now(), 'updated_at' => now()],
                    ['batch_number' => 'B007-002', 'manufacturing_date' => '2023-04-15', 'expiry_date' => '2025-04-14', 'created_at' => now(), 'updated_at' => now()],
                ],
                'transactions' => [
                    ['transaction_type' => 'purchase', 'quantity' => 300, 'unit_price' => 1.25, 'transaction_date' => now()->subMonths(4), 'created_at' => now()->subMonths(4), 'updated_at' => now()->subMonths(4)],
                    ['transaction_type' => 'purchase', 'quantity' => 200, 'unit_price' => 1.25, 'transaction_date' => now()->subMonths(2), 'created_at' => now()->subMonths(2), 'updated_at' => now()->subMonths(2)],
                    ['transaction_type' => 'issue', 'quantity' => 50, 'maintenance_id' => 7, 'transaction_date' => now()->subWeek(), 'created_at' => now()->subWeek(), 'updated_at' => now()->subWeek()],
                ],
            ],
            [
                'name' => 'Fertilizer',
                'description' => 'All-purpose fertilizer',
                'category_id' => 10,
                'manufacturer' => 'Scotts',
                'supplier' => 'Gardening Supplies Co.',
                'quantity_in_stock' => 1000,
                'reorder_level' => 200,
                'unit_price' => 9.99,
                'created_at' => now(),
                'updated_at' => now(),
                'batches' => [
                    ['batch_number' => 'B008-001', 'manufacturing_date' => '2023-03-01', 'expiry_date' => '2024-02-29', 'created_at' => now(), 'updated_at' => now()],
                    ['batch_number' => 'B008-002', 'manufacturing_date' => '2023-05-15', 'expiry_date' => '2024-05-14', 'created_at' => now(), 'updated_at' => now()],
                ],
                'transactions' => [
                    ['transaction_type' => 'purchase', 'quantity' => 500, 'unit_price' => 9.99, 'transaction_date' => now()->subMonths(3), 'created_at' => now()->subMonths(3), 'updated_at' => now()->subMonths(3)],
                    ['transaction_type' => 'purchase', 'quantity' => 500, 'unit_price' => 9.99, 'transaction_date' => now()->subMonths(1), 'created_at' => now()->subMonths(1), 'updated_at' => now()->subMonths(1)],
                    ['transaction_type' => 'issue', 'quantity' => 100, 'maintenance_id' => 8, 'transaction_date' => now()->subDays(5), 'created_at' => now()->subDays(5), 'updated_at' => now()->subDays(5)],
                ],
            ],
        ];

        foreach ($consumablesWithBatches as $consumableData) {
            $batches = [];

            foreach ($consumableData['batches'] as $batchData) {
                $batch = ConsumableBatches::create([
                    'batch_number' => $batchData['batch_number'],
                    'manufacturing_date' => $batchData['manufacturing_date'],
                    'expiry_date' => $batchData['expiry_date'],
                    'created_at' => $batchData['created_at'],
                    'updated_at' => $batchData['updated_at'],
                ]);

                $batches[] = $batch;
            }

            $lastBatch = end($batches);
        
            $consumable = Consumable::create([
                'name' => $consumableData['name'],
                'description' => $consumableData['description'],
                'category_id' => $consumableData['category_id'],
                'manufacturer' => $consumableData['manufacturer'],
                'supplier' => $consumableData['supplier'],
                'quantity_in_stock' => $consumableData['quantity_in_stock'],
                'reorder_level' => $consumableData['reorder_level'],
                'unit_price' => $consumableData['unit_price'],
                'batch_id' => $lastBatch->id,
                'created_at' => $consumableData['created_at'],
                'updated_at' => $consumableData['updated_at'],
            ]);

            foreach ($consumableData['transactions'] as $transactionData) {
                $transaction = ConsumableTransaction::create([
                    'consumable_id' => $consumable->id,
                    'transaction_type' => $transactionData['transaction_type'],
                    'quantity' => $transactionData['quantity'],
                    'unit_price' => $transactionData['unit_price'],
                    'transaction_date' => $transactionData['transaction_date'],
                    'created_at' => $transactionData['created_at'],
                    'updated_at' => $transactionData['updated_at'],
                ]);

                if ($transactionData['transaction_type'] === 'issue') {
                    $transaction->maintenance_id = $transactionData['maintenance_id'];
                    $transaction->batch_id = $consumable->batch_id;
                    $transaction->save();
                }
            }
        }

        // Create consumables without batches
        $consumablesWithoutBatches = [
            [
                'name' => 'Printer Paper',
                'description' => 'A4 size printer paper',
                'category_id' => 4,
                'manufacturer' => 'HP',
                'supplier' => 'Office Depot',
                'quantity_in_stock' => 10000,
                'reorder_level' => 2000,
                'unit_price' => 0.05,
                'created_at' => now(),
                'updated_at' => now(),
                'transactions' => [
                    ['transaction_type' => 'purchase', 'quantity' => 5000, 'unit_price' => 0.05, 'transaction_date' => now()->subMonths(6), 'created_at' => now()->subMonths(6), 'updated_at' => now()->subMonths(6)],
                    ['transaction_type' => 'purchase', 'quantity' => 5000, 'unit_price' => 0.05, 'transaction_date' => now()->subMonths(3), 'created_at' => now()->subMonths(3), 'updated_at' => now()->subMonths(3)],
                    ['transaction_type' => 'issue', 'quantity' => 1000, 'maintenance_id' => 9, 'transaction_date' => now()->subDays(5), 'created_at' => now()->subDays(5), 'updated_at' => now()->subDays(5)],
                ],
            ],
            [
                'name' => 'Stapler',
                'description' => 'Desktop stapler',
                'category_id' => 4,
                'manufacturer' => 'Swingline',
                'supplier' => 'Staples',
                'quantity_in_stock' => 200,
                'reorder_level' => 50,
                'unit_price' => 5.99,
                'created_at' => now(),
                'updated_at' => now(),
                'transactions' => [
                    ['transaction_type' => 'purchase', 'quantity' => 100, 'unit_price' => 5.99, 'transaction_date' => now()->subMonths(4), 'created_at' => now()->subMonths(4), 'updated_at' => now()->subMonths(4)],
                    ['transaction_type' => 'purchase', 'quantity' => 100, 'unit_price' => 5.99, 'transaction_date' => now()->subMonths(2), 'created_at' => now()->subMonths(2), 'updated_at' => now()->subMonths(2)],
                    ['transaction_type' => 'issue', 'quantity' => 20, 'maintenance_id' => 10, 'transaction_date' => now()->subWeek(), 'created_at' => now()->subWeek(), 'updated_at' => now()->subWeek()],
                ],
            ],
            [
                'name' => 'Safety Glasses',
                'description' => 'Clear safety glasses',
                'category_id' => 5,
                'manufacturer' => '3M',
                'supplier' => 'Industrial Safety Supply',
                'quantity_in_stock' => 500,
                'reorder_level' => 100,
                'unit_price' => 3.49,
                'created_at' => now(),
                'updated_at' => now(),
                'transactions' => [
                    ['transaction_type' => 'purchase', 'quantity' => 300, 'unit_price' => 3.49, 'transaction_date' => now()->subMonths(5), 'created_at' => now()->subMonths(5), 'updated_at' => now()->subMonths(5)],
                    ['transaction_type' => 'purchase', 'quantity' => 200, 'unit_price' => 3.49, 'transaction_date' => now()->subMonths(2), 'created_at' => now()->subMonths(2), 'updated_at' => now()->subMonths(2)],
                    ['transaction_type' => 'issue', 'quantity' => 50, 'maintenance_id' => 11, 'transaction_date' => now()->subDays(4), 'created_at' => now()->subDays(4), 'updated_at' => now()->subDays(4)],
                ],
            ],
            [
                'name' => 'Notepad',
                'description' => 'Ruled notepad',
                'category_id' => 4,
                'manufacturer' => 'Mead',
                'supplier' => 'Office Max',
                'quantity_in_stock' => 1000,
                'reorder_level' => 200,
                'unit_price' => 1.99,
                'created_at' => now(),
                'updated_at' => now(),
                'transactions' => [
                    ['transaction_type' => 'purchase', 'quantity' => 500, 'unit_price' => 1.99, 'transaction_date' => now()->subMonths(3), 'created_at' => now()->subMonths(3), 'updated_at' => now()->subMonths(3)],
                    ['transaction_type' => 'purchase', 'quantity' => 500, 'unit_price' => 1.99, 'transaction_date' => now()->subMonth(), 'created_at' => now()->subMonth(), 'updated_at' => now()->subMonth()],
                    ['transaction_type' => 'issue', 'quantity' => 100, 'maintenance_id' => 12, 'transaction_date' => now()->subDays(3), 'created_at' => now()->subDays(3), 'updated_at' => now()->subDays(3)],
                ],
            ],
            [
                'name' => 'Hammer',
                'description' => '16 oz claw hammer',
                'category_id' => 8,
                'manufacturer' => 'Stanley',
                'supplier' => 'Hardware Depot',
                'quantity_in_stock' => 100,
                'reorder_level' => 20,
                'unit_price' => 12.99,
                'created_at' => now(),
                'updated_at' => now(),
                'transactions' => [
                    ['transaction_type' => 'purchase', 'quantity' => 50, 'unit_price' => 12.99, 'transaction_date' => now()->subMonths(4), 'created_at' => now()->subMonths(4), 'updated_at' => now()->subMonths(4)],
                    ['transaction_type' => 'purchase', 'quantity' => 50, 'unit_price' => 12.99, 'transaction_date' => now()->subMonths(2), 'created_at' => now()->subMonths(2), 'updated_at' => now()->subMonths(2)],
                    ['transaction_type' => 'issue', 'quantity' => 10, 'maintenance_id' => 13, 'transaction_date' => now()->subWeek(), 'created_at' => now()->subWeek(), 'updated_at' => now()->subWeek()],
                ],
            ],
            [
                'name' => 'Screwdriver Set',
                'description' => '6-piece screwdriver set',
                'category_id' => 8,
                'manufacturer' => 'Klein Tools',
                'supplier' => 'Tool Supply Co.',
                'quantity_in_stock' => 50,
                'reorder_level' => 10,
                'unit_price' => 24.99,
                'created_at' => now(),
                'updated_at' => now(),
                'transactions' => [
                    ['transaction_type' => 'purchase', 'quantity' => 30, 'unit_price' => 24.99, 'transaction_date' => now()->subMonths(3), 'created_at' => now()->subMonths(3), 'updated_at' => now()->subMonths(3)],
                    ['transaction_type' => 'purchase', 'quantity' => 20, 'unit_price' => 24.99, 'transaction_date' => now()->subMonth(), 'created_at' => now()->subMonth(), 'updated_at' => now()->subMonth()],
                    ['transaction_type' => 'issue', 'quantity' => 5, 'maintenance_id' => 14, 'transaction_date' => now()->subDays(2), 'created_at' => now()->subDays(2), 'updated_at' => now()->subDays(2)],
                ],
            ],

            [
                'name' => 'Duct Tape',
                'description' => 'Heavy-duty duct tape',
                'category_id' => 7,
                'manufacturer' => 'Gorilla Tape',
                'supplier' => 'Adhesive Solutions Inc.',
                'quantity_in_stock' => 200,
                'reorder_level' => 50,
                'unit_price' => 4.99,
                'created_at' => now(),
                'updated_at' => now(),
                'transactions' => [
                    ['transaction_type' => 'purchase', 'quantity' => 100, 'unit_price' => 4.99, 'transaction_date' => now()->subMonths(5), 'created_at' => now()->subMonths(5), 'updated_at' => now()->subMonths(5)],
                    ['transaction_type' => 'purchase', 'quantity' => 100, 'unit_price' => 4.99, 'transaction_date' => now()->subMonths(2), 'created_at' => now()->subMonths(2), 'updated_at' => now()->subMonths(2)],
                    ['transaction_type' => 'issue', 'quantity' => 20, 'maintenance_id' => 15, 'transaction_date' => now()->subDays(4), 'created_at' => now()->subDays(4), 'updated_at' => now()->subDays(4)],
                ],
            ],
            [
                'name' => 'Measuring Tape',
                'description' => '25 ft measuring tape',
                'category_id' => 8,
                'manufacturer' => 'Milwaukee',
                'supplier' => 'Construction Supply Warehouse',
                'quantity_in_stock' => 80,
                'reorder_level' => 15,
                'unit_price' => 9.99,
                'created_at' => now(),
                'updated_at' => now(),
                'transactions' => [
                    ['transaction_type' => 'purchase', 'quantity' => 50, 'unit_price' => 9.99, 'transaction_date' => now()->subMonths(4), 'created_at' => now()->subMonths(4), 'updated_at' => now()->subMonths(4)],
                    ['transaction_type' => 'purchase', 'quantity' => 30, 'unit_price' => 9.99, 'transaction_date' => now()->subMonths(2), 'created_at' => now()->subMonths(2), 'updated_at' => now()->subMonths(2)],
                    ['transaction_type' => 'issue', 'quantity' => 10, 'maintenance_id' => 16, 'transaction_date' => now()->subWeek(), 'created_at' => now()->subWeek(), 'updated_at' => now()->subWeek()],
                ],
            ],
            [
                'name' => 'Safety Vest',
                'description' => 'High-visibility safety vest',
                'category_id' => 5,
                'manufacturer' => 'SafetyWear Inc.',
                'supplier' => 'Industrial Safety Co.',
                'quantity_in_stock' => 200,
                'reorder_level' => 50,
                'unit_price' => 7.99,
                'created_at' => now(),
                'updated_at' => now(),
                'transactions' => [
                    ['transaction_type' => 'purchase', 'quantity' => 100, 'unit_price' => 7.99, 'transaction_date' => now()->subMonths(6), 'created_at' => now()->subMonths(6), 'updated_at' => now()->subMonths(6)],
                    ['transaction_type' => 'purchase', 'quantity' => 100, 'unit_price' => 7.99, 'transaction_date' => now()->subMonths(3), 'created_at' => now()->subMonths(3), 'updated_at' => now()->subMonths(3)],
                    ['transaction_type' => 'issue', 'quantity' => 20, 'maintenance_id' => 17, 'transaction_date' => now()->subDays(3), 'created_at' => now()->subDays(3), 'updated_at' => now()->subDays(3)],
                ],
            ],
        ];

        foreach ($consumablesWithBatches as $consumableData) {
            $consumable = Consumable::create([
                'name' => $consumableData['name'],
                'description' => $consumableData['description'],
                'category_id' => $consumableData['category_id'],
                'manufacturer' => $consumableData['manufacturer'],
                'supplier' => $consumableData['supplier'],
                'quantity_in_stock' => $consumableData['quantity_in_stock'],
                'reorder_level' => $consumableData['reorder_level'],
                'unit_price' => $consumableData['unit_price'],
                'created_at' => $consumableData['created_at'],
                'updated_at' => $consumableData['updated_at'],
            ]);

            foreach ($consumableData['batches'] as $batchData) {
                $batch = ConsumableBatches::create([
                    'consumable_id' => $consumable->id,
                    'batch_number' => $batchData['batch_number'],
                    'manufacturing_date' => $batchData['manufacturing_date'],
                    'expiry_date' => $batchData['expiry_date'],
                    'created_at' => $batchData['created_at'],
                    'updated_at' => $batchData['updated_at'],
                ]);

                // Associate the consumable with the created batch
                $consumable->batch_id = $batch->id;
                $consumable->save();
            }

            foreach ($consumableData['transactions'] as $transactionData) {
                $transaction = ConsumableTransaction::create([
                    'consumable_id' => $consumable->id,
                    'transaction_type' => $transactionData['transaction_type'],
                    'quantity' => $transactionData['quantity'],
                    'unit_price' => $transactionData['unit_price'],
                    'transaction_date' => $transactionData['transaction_date'],
                    'created_at' => $transactionData['created_at'],
                    'updated_at' => $transactionData['updated_at'],
                ]);

                if ($transactionData['transaction_type'] === 'issue') {
                    $transaction->maintenance_id = $transactionData['maintenance_id'];
                    $transaction->batch_id = $consumable->batch_id;
                    $transaction->save();
                }
            }
        }

        foreach ($consumablesWithoutBatches as $consumableData) {
            $consumable = Consumable::create([
                'name' => $consumableData['name'],
                'description' => $consumableData['description'],
                'category_id' => $consumableData['category_id'],
                'manufacturer' => $consumableData['manufacturer'],
                'supplier' => $consumableData['supplier'],
                'quantity_in_stock' => $consumableData['quantity_in_stock'],
                'reorder_level' => $consumableData['reorder_level'],
                'unit_price' => $consumableData['unit_price'],
                'created_at' => $consumableData['created_at'],
                'updated_at' => $consumableData['updated_at'],
            ]);

            foreach ($consumableData['transactions'] as $transactionData) {
                $transaction = ConsumableTransaction::create([
                    'consumable_id' => $consumable->id,
                    'transaction_type' => $transactionData['transaction_type'],
                    'quantity' => $transactionData['quantity'],
                    'unit_price' => $transactionData['unit_price'],
                    'transaction_date' => $transactionData['transaction_date'],
                    'created_at' => $transactionData['created_at'],
                    'updated_at' => $transactionData['updated_at'],
                ]);

                if ($transactionData['transaction_type'] === 'issue') {
                    $transaction->maintenance_id = $transactionData['maintenance_id'];
                    $transaction->save();
                }
            }
        }
    }
}

