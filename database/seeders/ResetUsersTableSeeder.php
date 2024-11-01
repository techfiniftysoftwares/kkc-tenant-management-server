<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ResetUsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Delete all entries from the users table
        DB::table('users')->truncate();

        // Reset auto-increment ID to start from 1
        DB::statement('ALTER TABLE users AUTO_INCREMENT = 1');
    }
}