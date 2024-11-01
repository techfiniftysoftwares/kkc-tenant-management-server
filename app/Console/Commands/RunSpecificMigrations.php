<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class RunSpecificMigrations extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'migrate:specific';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Run specific migrations';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $migrations = [
            '2024_07_18_145930_create_doors_table.php',
            '2024_07_18_150147_create_windows_table.php',
            '2024_07_18_150437_create_furniture_table.php',
            '2024_07_18_150605_create_lightings_table.php',
            '2024_07_18_150745_create_plumbings_table.php',
            '2024_07_18_150932_create_electricals_table.php',
            '2024_07_18_151357_create_hvacs_table.php',
            '2024_07_18_152153_create_fire_protections_table.php',
            '2024_07_18_152447_create_securities_table.php',
            '2024_07_18_152613_create_elevators_table.php',
            '2024_07_29_123305_create_tool_categories_table.php',
            '2024_07_29_123607_create_tool_types_table.php',
            '2024_07_29_134005_create_tools_table.php',
        ];

        foreach ($migrations as $migration) {
            $this->call('migrate', [
                '--path' => 'database/migrations/' . $migration,
            ]);
        }
    }
}
