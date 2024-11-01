<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\UserLocation;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;

class UserLocationController extends Controller
{
    /**
     * Get user locations
     */
    public function index(): JsonResponse
    {
        try {
            $locations = UserLocation::with(['facility', 'branch', 'buildingAttribute'])
                ->where('user_id', auth()->id())
                ->get();

            return successResponse('Locations retrieved successfully', $locations);
        } catch (\Exception $e) {
            return queryErrorResponse('Failed to retrieve locations', $e->getMessage());
        }
    }

    /**
     * Store new location
     */
    public function store(Request $request): JsonResponse
    {
        try {
            $validated = $request->validate([
                'facility_id' => 'required|exists:facilities,id',
                'branch_id' => 'required|exists:branches,id',
                'building_attribute_id' => 'nullable|exists:building_attributes,id',
            ]);

            $location = UserLocation::create([
                'user_id' => auth()->id(),
                'facility_id' => $validated['facility_id'],
                'branch_id' => $validated['branch_id'],
                'building_attribute_id' => $validated['building_attribute_id'] ?? null,
            ]);

            $location->load(['facility', 'branch', 'buildingAttribute']);

            return successResponse('Location assigned successfully', $location);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return validationErrorResponse($e->errors());
        } catch (\Exception $e) {
            return queryErrorResponse('Failed to assign location', $e->getMessage());
        }
    }

    /**
     * Update location
     */
    public function update(Request $request, UserLocation $location): JsonResponse
    {
        if ($location->user_id !== auth()->id()) {
            return errorResponse('Unauthorized access', 403);
        }

        try {
            $validated = $request->validate([
                'facility_id' => 'required|exists:facilities,id',
                'branch_id' => 'required|exists:branches,id',
                'building_attribute_id' => 'nullable|exists:building_attributes,id',
            ]);

            $location->update($validated);
            $location->load(['facility', 'branch', 'buildingAttribute']);

            return updatedResponse($location, 'Location updated successfully');
        } catch (\Illuminate\Validation\ValidationException $e) {
            return validationErrorResponse($e->errors());
        } catch (\Exception $e) {
            return queryErrorResponse('Failed to update location', $e->getMessage());
        }
    }

    /**
     * Delete location
     */
    public function destroy(UserLocation $location): JsonResponse
    {
        if ($location->user_id !== auth()->id()) {
            return errorResponse('Unauthorized access', 403);
        }

        try {
            $location->delete();
            return deleteResponse('Location removed successfully');
        } catch (\Exception $e) {
            return queryErrorResponse('Failed to remove location', $e->getMessage());
        }
    }

    /**
     * Assign multiple locations
     */
    public function assignMultiple(Request $request): JsonResponse
    {
        try {
            $validated = $request->validate([
                'locations' => 'required|array',
                'locations.*.facility_id' => 'required|exists:facilities,id',
                'locations.*.branch_id' => 'required|exists:branches,id',
                'locations.*.building_attribute_id' => 'nullable|exists:building_attributes,id',
            ]);

            DB::transaction(function () use ($validated, $request) {
                if ($request->boolean('clear_existing')) {
                    UserLocation::where('user_id', auth()->id())->delete();
                }

                foreach ($validated['locations'] as $locationData) {
                    UserLocation::create([
                        'user_id' => auth()->id(),
                        'facility_id' => $locationData['facility_id'],
                        'branch_id' => $locationData['branch_id'],
                        'building_attribute_id' => $locationData['building_attribute_id'] ?? null,
                    ]);
                }
            });

            $locations = UserLocation::with(['facility', 'branch', 'buildingAttribute'])
                ->where('user_id', auth()->id())
                ->get();

            return successResponse('Locations assigned successfully', $locations);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return validationErrorResponse($e->errors());
        } catch (\Exception $e) {
            return queryErrorResponse('Failed to assign locations', $e->getMessage());
        }
    }
}