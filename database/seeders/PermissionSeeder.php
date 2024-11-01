<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Module;
use App\Models\Permission;
use App\Models\Role;

class PermissionSeeder extends Seeder
{
    public function run()
    {
        // Seed roles
        $roles = [
            'Facilty Manager',
            'User',
            'Technician',
            'Developer'
        ];
        foreach ($roles as $role) {
            Role::create(['name' => $role]);
        }
        $this->command->info('Roles seeded successfully.');

        // Seed permissions
        $actions = ['create', 'read', 'update', 'delete'];
        $modules = Module::with('submodules')->get();
        foreach ($modules as $module) {
            foreach ($module->submodules as $submodule) {
                foreach ($actions as $action) {
                    Permission::create([
                        'module_id' => $module->id,
                        'submodule_id' => $submodule->id,
                        'action' => $action
                    ]);
                }
            }
        }
        $this->command->info('Permissions seeded successfully.');

        // Assign all permissions to all roles
        $roles = Role::all();
        $allPermissions = Permission::all();
        foreach ($roles as $role) {
            $role->permissions()->sync($allPermissions->pluck('id')->toArray());
        }
        $this->command->info('All permissions have been assigned to all roles.');
    }
}
