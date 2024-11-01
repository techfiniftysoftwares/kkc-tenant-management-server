<?php

namespace Database\Seeders;

use App\Models\WorkOrderType;
use Illuminate\Database\Seeder;

class WorkOrderTypesTableSeeder extends Seeder
{
    public function run()
    {
        $workOrderTypes = [
            ['name' => 'Preventive'],
            ['name' => 'Reactive'],
        ];

        foreach ($workOrderTypes as $workOrderType) {
            WorkOrderType::create($workOrderType);
        }
    }
}