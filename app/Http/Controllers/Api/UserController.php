<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Role;
use App\Models\UserLocation;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        try {
            $search = $request->input('search');
            $query = User::query();

            if ($search) {
                $query->where(function ($query) use ($search) {
                    $query->where('username', 'like', "%$search%")
                        ->orWhere('email', 'like', "%$search%")
                        ->orWhere('firstname', 'like', "%$search%")
                        ->orWhere('lastname', 'like', "%$search%");
                });
            }

            $users = $query->with(['locations.facility', 'locations.branch', 'locations.buildingAttribute'])
                ->get()
                ->map(function ($user) {
                    $userData = $user->only([
                        'id',
                        'firstname',
                        'lastname',
                        'username',
                        'phone',
                        'position',
                        'status',
                        'email'
                    ]);

                    // Add role information
                    $roleId = $user->role_id;
                    if ($roleId) {
                        $role = Role::find($roleId);
                        $userData['role'] = $role ? $role->only(['id', 'name']) : null;
                    } else {
                        $userData['role'] = null;
                    }

                    // Add location information
                    if ($user->locations->isNotEmpty()) {
                        $primaryLocation = $user->locations->first();
                        $userData['location'] = [
                            'facility' => $primaryLocation->facility ? $primaryLocation->facility->only(['id', 'name']) : null,
                            'branch' => $primaryLocation->branch ? $primaryLocation->branch->only(['id', 'name']) : null,
                            'building_attribute' => $primaryLocation->buildingAttribute ? $primaryLocation->buildingAttribute->only(['id', 'name']) : null,
                        ];
                    } else {
                        $userData['location'] = null;
                    }

                    return $userData;
                });

            if ($users->isEmpty()) {
                return notFoundResponse('No matching records found.');
            }

            return successResponse('Users retrieved successfully', $users);
        } catch (\Exception $e) {
            return queryErrorResponse('An error occurred while retrieving users.', $e->getMessage());
        }
    }

    /**
     * Get authenticated user's profile
     */
    public function getProfile(Request $request)
    {
        try {
            $user = $request->user();
            $userData = $user->only([
                'id', 'firstname', 'lastname', 'username', 'phone', 
                'position', 'status', 'email'
            ]);

            // Add role and permissions
            $roleId = $user->role_id;
            if ($roleId) {
                $role = Role::with('permissions')->find($roleId);
                if ($role) {
                    $userData['role'] = $role->only(['id', 'name']);
                    $userData['permissions'] = $role->permissions->map(function ($permission) {
                        return [
                            'module' => $permission->module->name,
                            'submodule' => $permission->submodule->title,
                            'action' => $permission->action,
                        ];
                    });
                }
            }

            // Add location information
            $location = $user->locations()
                ->with(['facility', 'branch', 'buildingAttribute'])
                ->first();

            if ($location) {
                $userData['location'] = [
                    'facility' => $location->facility ? $location->facility->only(['id', 'name']) : null,
                    'branch' => $location->branch ? $location->branch->only(['id', 'name']) : null,
                    'building_attribute' => $location->buildingAttribute ? $location->buildingAttribute->only(['id', 'name']) : null,
                ];
            } else {
                $userData['location'] = null;
            }

            return successResponse('User profile retrieved successfully', $userData);
        } catch (\Exception $e) {
            return queryErrorResponse('An error occurred while retrieving user profile.', $e->getMessage());
        }
    }

    /**
     * Update user profile
     */
    public function updateProfile(Request $request)
    {
        try {
            $user = $request->user();
            $validatedData = $request->validate([
                'firstname' => 'sometimes|string',
                'lastname' => 'sometimes|string',
                'email' => 'sometimes|string|email|unique:users,email,' . $user->id,
                'username' => 'sometimes|string|unique:users,username,' . $user->id,
                'phone' => 'sometimes|string',
                'position' => 'sometimes|string',
                'password' => 'sometimes|string|min:8',
                'password_confirmation' => 'sometimes|required_with:password|same:password',
            ]);

            // Update user data
            $updateData = collect($validatedData)
                ->except(['password', 'password_confirmation'])
                ->filter()
                ->toArray();

            if (isset($validatedData['password'])) {
                $updateData['password'] = Hash::make($validatedData['password']);
            }

            $user->update($updateData);

            return successResponse('User profile updated successfully', new UserResource($user));
        } catch (\Exception $e) {
            return queryErrorResponse('An error occurred while updating user profile.', $e->getMessage());
        }
    }

    /**
     * Update user specifics including location
     */
    public function updateUserSpecifics(Request $request, User $user)
    {
        try {
            $validator = Validator::make($request->all(), [
                'position' => 'sometimes|string|max:255',
                'role_id' => 'sometimes|exists:roles,id',
                'status' => 'sometimes|string|in:active,inactive',
                'location' => 'sometimes|array',
                'location.facility_id' => 'required_with:location|exists:facilities,id',
                'location.branch_id' => 'required_with:location|exists:branches,id',
                'location.building_attribute_id' => 'sometimes|exists:building_attributes,id',
            ]);

            if ($validator->fails()) {
                return validationErrorResponse($validator->errors());
            }

            $validated = $validator->validated();

            // Update user details
            $userUpdateData = collect($validated)
                ->only(['position', 'role_id', 'status'])
                ->filter()
                ->toArray();

            $user->update($userUpdateData);

            // Update location if provided
            if (isset($validated['location'])) {
                // Update or create location
                UserLocation::updateOrCreate(
                    ['user_id' => $user->id],
                    $validated['location']
                );
            }

            // Reload user with relationships
            $user->load('locations.facility', 'locations.branch', 'locations.buildingAttribute');

            return updatedResponse($user, 'User details updated successfully');
        } catch (\Exception $e) {
            return queryErrorResponse('An error occurred while updating user details.', $e->getMessage());
        }
    }

    /**
     * Get users by branch
     */
    public function getUsersByBranch($branchId)
    {
        try {
            $users = User::whereHas('locations', function ($query) use ($branchId) {
                $query->where('branch_id', $branchId);
            })
            ->with(['locations.facility', 'locations.branch', 'locations.buildingAttribute', 'role'])
            ->get()
            ->map(function ($user) {
                $location = $user->locations->first();
                return [
                    'id' => $user->id,
                    'firstname' => $user->firstname,
                    'lastname' => $user->lastname,
                    'username' => $user->username,
                    'phone' => $user->phone,
                    'position' => $user->position,
                    'status' => $user->status,
                    'email' => $user->email,
                    'role' => $user->role ? $user->role->only(['id', 'name']) : null,
                    'location' => $location ? [
                        'facility' => $location->facility ? $location->facility->only(['id', 'name']) : null,
                        'branch' => $location->branch ? $location->branch->only(['id', 'name']) : null,
                        'building_attribute' => $location->buildingAttribute ? $location->buildingAttribute->only(['id', 'name']) : null,
                    ] : null
                ];
            });

            if ($users->isEmpty()) {
                return notFoundResponse('No users found in this branch.');
            }

            return successResponse('Users in branch retrieved successfully', $users);
        } catch (\Exception $e) {
            return queryErrorResponse('An error occurred while retrieving users.', $e->getMessage());
        }
    }
}