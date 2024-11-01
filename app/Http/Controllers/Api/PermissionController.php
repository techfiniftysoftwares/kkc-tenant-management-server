<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Permission;
use App\Models\Role;

class PermissionController extends Controller
{
    public function index()
    {
        $permissions = Permission::all();

        return successResponse('Permissions retrieved successfully', $permissions);
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'module_id' => 'required|exists:modules,id',
            'submodule_id' => 'required|exists:submodules,id',
            'action' => 'required|string|max:255',
        ]);

        $permission = Permission::create($validatedData);

        return createdResponse($permission, 'Permission created successfully');
    }

    public function update(Request $request, Permission $permission)
    {
        $validatedData = $request->validate([
            'module_id' => 'required|exists:modules,id',
            'submodule_id' => 'required|exists:submodules,id',
            'action' => 'required|string|max:255',
        ]);

        $permission->update($validatedData);

        return updatedResponse($permission, 'Permission updated successfully');
    }

    public function destroy(Permission $permission)
    {
        $permission->delete();

        return deleteResponse('Permission deleted successfully');
    }


}
