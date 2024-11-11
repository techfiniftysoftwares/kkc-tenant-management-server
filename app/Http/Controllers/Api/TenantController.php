<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Tenant;
use Illuminate\Support\Facades\DB;
use Exception;

class TenantController extends Controller
{
    public function index()
    {
        try {
            $tenants = Tenant::with(['activeLeases.unit.property'])->get();
            
            if ($tenants->isEmpty()) {
                return notFoundResponse('No tenants found');
            }

            return successResponse('Tenants retrieved successfully', $tenants);
        } catch (Exception $e) {
            return serverErrorResponse('Failed to retrieve tenants', $e->getMessage());
        }
    }

    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'first_name' => 'required|string|max:255',
                'last_name' => 'required|string|max:255',
                'email' => 'required|email|unique:tenants',
                'phone' => 'required|string|max:20',
                'emergency_contact_name' => 'nullable|string|max:255',
                'emergency_contact_phone' => 'nullable|string|max:20',
                'id_number' => 'required|string|unique:tenants',
                'address_history' => 'nullable|string',
                'employment_details' => 'nullable|string'
            ]);

            $tenant = DB::transaction(function () use ($validated) {
                return Tenant::create($validated);
            });

            return createdResponse('Tenant created successfully');
        } catch (\Illuminate\Validation\ValidationException $e) {
            return validationErrorResponse($e->errors());
        } catch (Exception $e) {
            return queryErrorResponse('Failed to create tenant', $e->getMessage());
        }
    }

    public function show($id)
    {
        try {
            $tenant = Tenant::with(['activeLeases.unit.property'])->find($id);
            
            if (!$tenant) {
                return notFoundResponse('Tenant not found');
            }

            return successResponse('Tenant retrieved successfully', $tenant);
        } catch (Exception $e) {
            return serverErrorResponse('Failed to retrieve tenant', $e->getMessage());
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $tenant = Tenant::find($id);
            
            if (!$tenant) {
                return notFoundResponse('Tenant not found');
            }

            $validated = $request->validate([
                'first_name' => 'string|max:255',
                'last_name' => 'string|max:255',
                'email' => 'email|unique:tenants,email,'.$id,
                'phone' => 'string|max:20',
                'emergency_contact_name' => 'nullable|string|max:255',
                'emergency_contact_phone' => 'nullable|string|max:20',
                'id_number' => 'string|unique:tenants,id_number,'.$id,
                'address_history' => 'nullable|string',
                'employment_details' => 'nullable|string'
            ]);

            DB::transaction(function () use ($tenant, $validated) {
                $tenant->update($validated);
            });

            return updatedResponse($tenant, 'Tenant updated successfully');
        } catch (\Illuminate\Validation\ValidationException $e) {
            return validationErrorResponse($e->errors());
        } catch (Exception $e) {
            return queryErrorResponse('Failed to update tenant', $e->getMessage());
        }
    }

    public function destroy($id)
    {
        try {
            $tenant = Tenant::find($id);
            
            if (!$tenant) {
                return notFoundResponse('Tenant not found');
            }

            DB::transaction(function () use ($tenant) {
                $tenant->delete();
            });

            return deleteResponse('Tenant deleted successfully');
        } catch (Exception $e) {
            return serverErrorResponse('Failed to delete tenant', $e->getMessage());
        }
    }
}