<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Asset;
use App\Models\Technician;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Faker\Factory as Faker;

class MaintenanceLogsSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create();

        $managerRole = Role::where('name', 'manager')->first();
        $managers = $managerRole->users()->pluck('id')->toArray();

        $assets = Asset::pluck('id')->toArray();
        $technicians = Technician::pluck('id')->toArray();

        $numRecords = 100;

        for ($i = 0; $i < $numRecords; $i++) {
            $approvalDate = $faker->dateTimeBetween('-1 year', 'now');

            DB::table('maintenance_logs')->insert([
                'asset_id' => $faker->randomElement($assets),
                'maintenance_type' => $faker->randomElement(['Preventive', 'Corrective']),
                'description' => $faker->sentence,
                'start_date' => $faker->dateTimeBetween('-1 year', 'now')->format('Y-m-d'),
                'end_date' => $faker->dateTimeBetween('-1 year', 'now')->format('Y-m-d'),
                'technician_id' => $faker->randomElement($technicians),
                'labour_hours' => $faker->numberBetween(1, 8),
                'cost' => $faker->randomFloat(2, 100, 5000),
                'notes' => $faker->optional()->paragraph,
                'next_maintenance_due' => $faker->dateTimeBetween('now', '+1 year')->format('Y-m-d'),
                'approval_status' => $faker->randomElement(['Approved', 'Pending']),
                'approval_date' => $approvalDate ? $approvalDate->format('Y-m-d') : null,
                'approved_by' => $faker->randomElement($managers),
            ]);
        }
    }
}
