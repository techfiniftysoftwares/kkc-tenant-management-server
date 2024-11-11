<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\PropertyManager;
use App\Models\User;
use App\Models\Property;
use Illuminate\Http\Request;
use Exception;
use Illuminate\Support\Facades\DB;

class PropertyManagerController extends Controller
{
    public function index()
    {
        try {
            $managers = PropertyManager::with(['user', 'property'])->get();
            
            if ($managers->isEmpty()) {
                return notFoundResponse('No property managers found');
            }

            return successResponse('Property managers retrieved successfully', $managers);
        } catch (Exception $e) {
            return serverErrorResponse('Failed to retrieve property managers', $e->getMessage());
        }
    }

    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'user_id' => 'required|exists:users,id',
                'property_id' => 'required|exists:properties,id',
                'assignment_date' => 'required|date',
                'notes' => 'nullable|string'
            ]);

            // Check if property already has an active manager
            $existingManager = PropertyManager::where('property_id', $validated['property_id'])
                ->where('status', 'active')
                ->exists();

            if ($existingManager) {
                return errorResponse('Property already has an active manager', 422);
            }

            // Verify user is a property manager
            $user = User::find($validated['user_id']);
            if ($user->role !== 'property_manager') {
                return errorResponse('User must have property manager role', 422);
            }

            $manager = DB::transaction(function () use ($validated) {
                return PropertyManager::create([
                    ...$validated,
                    'status' => 'active'
                ]);
            });

            return createdResponse('Property manager assigned successfully');
        } catch (\Illuminate\Validation\ValidationException $e) {
            return validationErrorResponse($e->errors());
        } catch (Exception $e) {
            return queryErrorResponse('Failed to assign property manager', $e->getMessage());
        }
    }

    public function show($id)
    {
        try {
            $manager = PropertyManager::with(['user', 'property'])->find($id);
            
            if (!$manager) {
                return notFoundResponse('Property manager not found');
            }

            return successResponse('Property manager retrieved successfully', $manager);
        } catch (Exception $e) {
            return serverErrorResponse('Failed to retrieve property manager', $e->getMessage());
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $manager = PropertyManager::find($id);
            
            if (!$manager) {
                return notFoundResponse('Property manager not found');
            }

            $validated = $request->validate([
                'assignment_date' => 'date',
                'end_date' => 'nullable|date|after:assignment_date',
                'status' => 'in:active,inactive',
                'notes' => 'nullable|string'
            ]);

            DB::transaction(function () use ($manager, $validated) {
                $manager->update($validated);
            });

            return updatedResponse($manager, 'Property manager updated successfully');
        } catch (\Illuminate\Validation\ValidationException $e) {
            return validationErrorResponse($e->errors());
        } catch (Exception $e) {
            return queryErrorResponse('Failed to update property manager', $e->getMessage());
        }
    }

    public function destroy($id)
    {
        try {
            $manager = PropertyManager::find($id);
            
            if (!$manager) {
                return notFoundResponse('Property manager not found');
            }

            DB::transaction(function () use ($manager) {
                $manager->update([
                    'status' => 'inactive',
                    'end_date' => now()
                ]);
            });

            return deleteResponse('Property manager removed successfully');
        } catch (Exception $e) {
            return serverErrorResponse('Failed to remove property manager', $e->getMessage());
        }
    }

    public function getActiveManagers()
    {
        try {
            $managers = PropertyManager::with(['user', 'property'])
                ->where('status', 'active')
                ->get();

            if ($managers->isEmpty()) {
                return notFoundResponse('No active property managers found');
            }

            return successResponse('Active property managers retrieved successfully', $managers);
        } catch (Exception $e) {
            return serverErrorResponse('Failed to retrieve active managers', $e->getMessage());
        }
    }

    public function getManagerProperties($id)
    {
        try {
            $manager = PropertyManager::with(['property.units'])->find($id);
            
            if (!$manager) {
                return notFoundResponse('Property manager not found');
            }

            return successResponse('Manager properties retrieved successfully', $manager->property);
        } catch (Exception $e) {
            return serverErrorResponse('Failed to retrieve manager properties', $e->getMessage());
        }
    }

    public function assignProperties(Request $request)
    {
        try {
            $validated = $request->validate([
                'user_id' => 'required|exists:users,id',
                'property_ids' => 'required|array',
                'property_ids.*' => 'exists:properties,id',
                'assignment_date' => 'required|date',
                'notes' => 'nullable|string'
            ]);

            // Verify user is a property manager
            $user = User::find($validated['user_id']);
            if ($user->role !== 'property_manager') {
                return errorResponse('User must have property manager role', 422);
            }

            DB::transaction(function () use ($validated) {
                // Deactivate current managers for these properties
                PropertyManager::whereIn('property_id', $validated['property_ids'])
                    ->where('status', 'active')
                    ->update([
                        'status' => 'inactive',
                        'end_date' => now()
                    ]);

                // Assign new manager to properties
                foreach ($validated['property_ids'] as $propertyId) {
                    PropertyManager::create([
                        'user_id' => $validated['user_id'],
                        'property_id' => $propertyId,
                        'assignment_date' => $validated['assignment_date'],
                        'status' => 'active',
                        'notes' => $validated['notes']
                    ]);
                }
            });

            return createdResponse('Properties assigned successfully');
        } catch (\Illuminate\Validation\ValidationException $e) {
            return validationErrorResponse($e->errors());
        } catch (Exception $e) {
            return queryErrorResponse('Failed to assign properties', $e->getMessage());
        }
    }

    public function deactivateManager($id)
    {
        try {
            $manager = PropertyManager::find($id);
            
            if (!$manager) {
                return notFoundResponse('Property manager not found');
            }

            if ($manager->status !== 'active') {
                return errorResponse('Manager is already inactive', 422);
            }

            DB::transaction(function () use ($manager) {
                $manager->update([
                    'status' => 'inactive',
                    'end_date' => now()
                ]);
            });

            return updatedResponse($manager, 'Manager deactivated successfully');
        } catch (Exception $e) {
            return serverErrorResponse('Failed to deactivate manager', $e->getMessage());
        }
    }
}