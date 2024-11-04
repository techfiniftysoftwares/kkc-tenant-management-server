<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Role;

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

            // Build the query
            $query = User::query();

            if ($search) {
                $query->where(function ($query) use ($search) {
                    $query->where('username', 'like', "%$search%")
                        ->orWhere('email', 'like', "%$search%")
                        ->orWhere('firstname', 'like', "%$search%")
                        ->orWhere('lastname', 'like', "%$search%");
                });
            }

            // Execute the query and get the results as a collection
            $users = $query->get()->map(function ($user) {
                $userData = $user->only([
                    'id',
                    'firstname',
                    'lastname',
                    'username',
                    'phone',
                    'status',
                    'email'
                ]);

                $roleId = $user->role_id;
                if ($roleId) {
                    $role = Role::find($roleId);
                    $userData['role'] = $role ? $role->only(['id', 'name']) : null;
                } else {
                    $userData['role'] = null;
                }

                return $userData;
            });

            if ($users->isEmpty()) {
                return queryErrorResponse('No matching records found.', null, 404);
            }

            return successResponse('Users retrieved successfully', $users);
        } catch (\Exception $e) {
            // Handle exceptions here
            return queryErrorResponse('An error occurred while retrieving users.', $e->getMessage(), 500);
        }
    }



    // the one to get user
    public function getProfile(Request $request)
    {
        try {
            $user = $request->user();
            $userData = $user->only([
                'id',
                'firstname',
                'lastname',
                'username',
                'phone',
                'status',
                'email'
            ]);

            $roleId = $user->role_id;
            if ($roleId) {
                $role = Role::with('permissions')->find($roleId);
                if ($role) {
                    $userData['role'] = $role->only(['id', 'name']);

                    $permissions = $role->permissions->map(function ($permission) {
                        return [
                            'module' => $permission->module->name,
                            'submodule' => $permission->submodule->title,
                            'action' => $permission->action,
                        ];
                    });

                    $userData['permissions'] = $permissions;
                } else {
                    $userData['role'] = null;
                    $userData['permissions'] = [];
                }
            } else {
                $userData['role'] = null;
                $userData['permissions'] = [];
            }

            return successResponse('User profile retrieved successfully', $userData);
        } catch (\Exception $e) {
            // Handle exceptions here
            return queryErrorResponse('An error occurred while retrieving user profile.', $e->getMessage(), 500);
        }
    }





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
                'password' => 'sometimes|string|min:8',
                'password_confirmation' => 'sometimes|required_with:password|same:password',
            ]);

            // Update only the fields that are present in the request
            $updatedData = [];
            if ($request->has('firstname')) {
                $updatedData['firstname'] = $validatedData['firstname'];
            }
            if ($request->has('lastname')) {
                $updatedData['lastname'] = $validatedData['lastname'];
            }
            if ($request->has('email')) {
                $updatedData['email'] = $validatedData['email'];
            }
            if ($request->has('username')) {
                $updatedData['username'] = $validatedData['username'];
            }
            if ($request->has('phone')) {
                $updatedData['phone'] = $validatedData['phone'];
            }

            if ($request->has('password')) {
                $updatedData['password'] = Hash::make($validatedData['password']);
                $user->password = $updatedData['password'];
                $user->save();
            }

            $user->update($updatedData);

            return successResponse('User profile updated successfully', $user);
        } catch (\Exception $e) {
            // Handle exceptions here
            return queryErrorResponse('An error occurred while updating user profile.', $e->getMessage(), 500);
        }
    }






    public function updateUserSpecifics(Request $request, User $user)
    {
        // Validate the request data
        $validator = Validator::make($request->all(), [
            'firstname' => 'sometimes|string',
            'lastname' => 'sometimes|string',
            'email' => 'sometimes|string|email|unique:users,email,' . $user->id,
            'username' => 'sometimes|string|unique:users,username,' . $user->id,
            'phone' => 'sometimes|string',
            'position' => 'sometimes|string|max:255',
            'role_id' => 'sometimes|exists:roles,id',
            'status' => 'sometimes|string|in:active,inactive',
        ]);

        // If validation fails, return the error messages
        if ($validator->fails()) {
            return validationErrorResponse($validator->errors());
        }

        // Update the user with the validated data only if the fields are present in the request
        if ($request->has('firstname')) {
            $user->firstname = $request->input('firstname');
        }

        if ($request->has('lastname')) {
            $user->lastname = $request->input('lastname');
        }

        if ($request->has('email')) {
            $user->email = $request->input('email');
        }

        if ($request->has('username')) {
            $user->username = $request->input('username');
        }

        if ($request->has('phone')) {
            $user->phone = $request->input('phone');
        }

        if ($request->has('position')) {
            $user->position = $request->input('position');
        }

        if ($request->has('status')) {
            $user->status = $request->input('status');
        }

        // Update the user's role
        if ($request->has('role_id')) {
            $user->role_id = $request->input('role_id');
        }

        $user->save();

        return updatedResponse($user, 'User details updated successfully');
    }






}
