<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use App\Models\User;
use App\Models\Location;

class AssignRolesToUsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
   

    public function run()
    {
        // Get all roles
        $roles = Role::all();

        // Get all users
        $users = User::all();

        foreach ($users as $user) {
            // Randomly select a role for the user
            $role = $roles->random();

            // Assign the selected role to the user
            $user->assignRole($role);
        }
    }
}
