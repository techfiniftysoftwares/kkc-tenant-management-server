<?php

namespace Database\Seeders;

use App\Models\ServiceContract;
use App\Models\Supplier;
use Illuminate\Database\Seeder;

class ServiceContractsTableSeeder extends Seeder
{
    public function run()
    {
        $serviceContracts = [
            [
                'supplier_id' => Supplier::inRandomOrder()->first()->id,
                'start_date' => '2023-01-01',
                'end_date' => '2023-12-31',
                'contract_type' => 'Maintenance',
                'description' => 'Quarterly HVAC maintenance',
                'cost' => 5000,
                'notes' => 'Includes filter changes and system inspection',
            ],
            [
                'supplier_id' => Supplier::inRandomOrder()->first()->id,
                'start_date' => '2023-01-01',
                'end_date' => '2023-12-31',
                'contract_type' => 'Maintenance',
                'description' => 'Semi-annual chiller maintenance',
                'cost' => 8000,
                'notes' => 'Includes compressor inspection and cleaning',
            ],
            [
                'supplier_id' => Supplier::inRandomOrder()->first()->id,
                'start_date' => '2023-01-01',
                'end_date' => '2023-12-31',
                'contract_type' => 'Maintenance',
                'description' => 'Annual boiler maintenance',
                'cost' => 3000,
                'notes' => 'Includes burner tuning and safety checks',
            ],
            [
                'supplier_id' => Supplier::inRandomOrder()->first()->id,
                'start_date' => '2023-01-01',
                'end_date' => '2023-12-31',
                'contract_type' => 'Maintenance',
                'description' => 'Bi-annual electrical maintenance',
                'cost' => 4000,
                'notes' => 'Includes panel cleaning and thermal imaging',
            ],
            [
                'supplier_id' => Supplier::inRandomOrder()->first()->id,
                'start_date' => '2023-01-01',
                'end_date' => '2023-12-31',
                'contract_type' => 'Monitoring',
                'description' => 'Fire alarm system monitoring',
                'cost' => 1200,
                'notes' => '24/7 monitoring and dispatch',
            ],
            [
                'supplier_id' => Supplier::inRandomOrder()->first()->id,
                'start_date' => '2023-01-01',
                'end_date' => '2023-12-31',
                'contract_type' => 'Maintenance',
                'description' => 'Monthly elevator maintenance',
                'cost' => 6000,
                'notes' => 'Includes safety checks and lubrication',
            ],
            [
                'supplier_id' => Supplier::inRandomOrder()->first()->id,
                'start_date' => '2023-01-01',
                'end_date' => '2023-12-31',
                'contract_type' => 'Maintenance',
                'description' => 'Semi-annual generator maintenance',
                'cost' => 2500,
                'notes' => 'Includes oil changes and load testing',
            ],
            [
                'supplier_id' => Supplier::inRandomOrder()->first()->id,
                'start_date' => '2023-02-01',
                'end_date' => '2024-01-31',
                'contract_type' => 'Service',
                'description' => 'Annual fire extinguisher inspection',
                'cost' => 1500,
                'notes' => 'Includes recharging and replacement as needed',
            ],
            [
                'supplier_id' => Supplier::inRandomOrder()->first()->id,
                'start_date' => '2023-03-01',
                'end_date' => '2024-02-29',
                'contract_type' => 'Maintenance',
                'description' => 'Quarterly plumbing maintenance',
                'cost' => 3500,
                'notes' => 'Includes drain cleaning and leak checks',
            ],
            [
                'supplier_id' => Supplier::inRandomOrder()->first()->id,
                'start_date' => '2023-04-01',
                'end_date' => '2024-03-31',
                'contract_type' => 'Monitoring',
                'description' => 'Security system monitoring',
                'cost' => 1800,
                'notes' => '24/7 monitoring and response',
            ],
            [
                'supplier_id' => Supplier::inRandomOrder()->first()->id,
                'start_date' => '2023-05-01',
                'end_date' => '2024-04-30',
                'contract_type' => 'Maintenance',
                'description' => 'Annual roof maintenance',
                'cost' => 4500,
                'notes' => 'Includes inspection and minor repairs',
            ],
            [
                'supplier_id' => Supplier::inRandomOrder()->first()->id,
                'start_date' => '2023-06-01',
                'end_date' => '2024-05-31',
                'contract_type' => 'Service',
                'description' => 'Bi-annual landscaping service',
                'cost' => 2000,
                'notes' => 'Includes mowing, trimming, and fertilization',
            ],
            [
                'supplier_id' => Supplier::inRandomOrder()->first()->id,
                'start_date' => '2023-07-01',
                'end_date' => '2024-06-30',
                'contract_type' => 'Maintenance',
                'description' => 'Quarterly elevator maintenance',
                'cost' => 7500,
                'notes' => 'Includes safety checks and repairs',
            ],
            [
                'supplier_id' => Supplier::inRandomOrder()->first()->id,
                'start_date' => '2023-08-01',
                'end_date' => '2024-07-31',
                'contract_type' => 'Monitoring',
                'description' => 'Water treatment system monitoring',
                'cost' => 1000,
                'notes' => 'Includes regular testing and adjustments',
            ],
            [
                'supplier_id' => Supplier::inRandomOrder()->first()->id,
                'start_date' => '2023-09-01',
                'end_date' => '2024-08-31',
                'contract_type' => 'Maintenance',
                'description' => 'Semi-annual HVAC maintenance',
                'cost' => 6500,
                'notes' => 'Includes coil cleaning and refrigerant check',
            ],
            [
                'supplier_id' => Supplier::inRandomOrder()->first()->id,
                'start_date' => '2023-10-01',
                'end_date' => '2024-09-30',
                'contract_type' => 'Service',
                'description' => 'Annual fire sprinkler inspection',
                'cost' => 2500,
                'notes' => 'Includes testing and maintenance',
            ],
            [
                'supplier_id' => Supplier::inRandomOrder()->first()->id,
                'start_date' => '2023-11-01',
                'end_date' => '2024-10-31',
                'contract_type' => 'Maintenance',
                'description' => 'Quarterly generator maintenance',
                'cost' => 3000,
                'notes' => 'Includes oil changes and load testing',
            ],
            [
                'supplier_id' => Supplier::inRandomOrder()->first()->id,
                'start_date' => '2023-12-01',
                'end_date' => '2024-11-30',
                'contract_type' => 'Monitoring',
                'description' => 'Elevator monitoring',
                'cost' => 1500,
                'notes' => '24/7 monitoring and dispatch',
            ],
            [
                'supplier_id' => Supplier::inRandomOrder()->first()->id,
                'start_date' => '2024-01-01',
                'end_date' => '2024-12-31',
                'contract_type' => 'Maintenance',
                'description' => 'Annual electrical maintenance',
                'cost' => 5000,
                'notes' => 'Includes infrared scanning and panel maintenance',
            ],
            [
                'supplier_id' => Supplier::inRandomOrder()->first()->id,
                'start_date' => '2024-02-01',
                'end_date' => '2025-01-31',
                'contract_type' => 'Service',
                'description' => 'Bi-annual pest control service',
                'cost' => 1800,
                'notes' => 'Includes inspection and treatment',
            ],
        ];

        foreach ($serviceContracts as $serviceContract) {
            ServiceContract::create($serviceContract);
        }
    }
}
