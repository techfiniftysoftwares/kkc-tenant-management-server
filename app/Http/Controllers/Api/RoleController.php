<?php

namespace App\Http\Controllers\Api;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Role;
use App\Models\Permission;

class RoleController extends Controller
{
    public function index()
    {
        $roles = Role::withCount(['users', 'permissions'])->get();

        $roles = $roles->map(function ($role) {
            $modules = $role->permissions->pluck('module.id')->unique();
            $submodules = $role->permissions->pluck('submodule.id')->unique();

            return [
                'id' => $role->id,
                'name' => $role->name,
                'users_count' => $role->users_count,
                'permissions_count' => $role->permissions_count,
                'modules_count' => $modules->count(),
                'submodules_count' => $submodules->count(),
            ];
        });

        return successResponse('Roles retrieved successfully', $roles);
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255|unique:roles',
        ]);

        $role = Role::create($validatedData);

        return createdResponse($role, 'Role created successfully');
    }

    public function show(Role $role)
    {
        $role->load('permissions.module', 'permissions.submodule');

        $modules = $role->permissions->pluck('module')->unique('id')->values();

        $moduleData = $modules->map(function ($module) use ($role) {
            $submodules = $role->permissions->where('module_id', $module->id)
                ->pluck('submodule')
                ->unique('id')
                ->values();

            $submoduleData = $submodules->map(function ($submodule) use ($role, $module) {
                $permissions = $role->permissions->where('module_id', $module->id)
                    ->where('submodule_id', $submodule->id)
                    ->pluck('action')
                    ->toArray();

                return [
                    'id' => $submodule->id,
                    'title' => $submodule->title,
                    'permissions' => $permissions,
                ];
            });

            return [
                'id' => $module->id,
                'name' => $module->name,
                'submodules' => $submoduleData,
            ];
        });

        $roleData = [
            'id' => $role->id,
            'name' => $role->name,
            'modules' => $moduleData,
        ];

        return successResponse('Role details retrieved successfully', $roleData);
    }

    public function update(Request $request, Role $role)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255|unique:roles,name,' . $role->id,
        ]);

        $role->update($validatedData);

        return updatedResponse($role, 'Role updated successfully');
    }

    public function destroy(Role $role)
    {
        $role->delete();

        return deleteResponse('Role deleted successfully');
    }

    public function updatePermissions(Request $request, Role $role)
    {
        $validatedData = $request->validate([
            'permissions' => 'required|array',
            'permissions.*.module_id' => 'required|exists:modules,id',
            'permissions.*.submodule_id' => 'required|exists:submodules,id',
            'permissions.*.actions' => 'present|array',
            'permissions.*.actions.*' => 'in:create,read,update,delete',
        ]);

        // Clear existing permissions
        $role->permissions()->detach();

        // Add new permissions
        foreach ($validatedData['permissions'] as $permissionData) {
            $module_id = $permissionData['module_id'];
            $submodule_id = $permissionData['submodule_id'];
            $actions = $permissionData['actions'];

            foreach ($actions as $action) {
                $permission = Permission::firstOrCreate([
                    'module_id' => $module_id,
                    'submodule_id' => $submodule_id,
                    'action' => $action,
                ]);

                $role->permissions()->attach($permission);
            }
        }

        return updatedResponse($role->load('permissions'), 'Role permissions updated successfully');
    }
}
