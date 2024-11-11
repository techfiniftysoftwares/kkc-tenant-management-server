<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;

use App\Models\Property;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

use Exception;

class PropertyController extends Controller
{
    public function index()
    {
        try {
            $properties = Property::with(['activePropertyManager.user', 'units'])->get();
            
            if ($properties->isEmpty()) {
                return notFoundResponse('No properties found');
            }

            return successResponse('Properties retrieved successfully', $properties);
        } catch (Exception $e) {
            return serverErrorResponse('Failed to retrieve properties', $e->getMessage());
        }
    }

    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'type' => 'required|in:house,apartment,commercial-apartment,commercial,land',
                'address' => 'required|string|max:255',
                'description' => 'nullable|string'
            ]);

            $property = DB::transaction(function () use ($validated) {
                return Property::create($validated);
            });

            return createdResponse('Property created successfully');
        } catch (\Illuminate\Validation\ValidationException $e) {
            return validationErrorResponse($e->errors());
        } catch (Exception $e) {
            return queryErrorResponse('Failed to create property', $e->getMessage());
        }
    }

    public function show($id)
    {
        try {
            $property = Property::with(['activePropertyManager.user', 'units'])->find($id);
            
            if (!$property) {
                return notFoundResponse('Property not found');
            }

            return successResponse('Property retrieved successfully', $property);
        } catch (Exception $e) {
            return serverErrorResponse('Failed to retrieve property', $e->getMessage());
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $property = Property::find($id);
            
            if (!$property) {
                return notFoundResponse('Property not found');
            }

            $validated = $request->validate([
                'name' => 'string|max:255',
                'type' => 'in:house,apartment,commercial-apartment,commercial,land',
                'address' => 'string|max:255',
                'description' => 'nullable|string'
            ]);

            DB::transaction(function () use ($property, $validated) {
                $property->update($validated);
            });

            return updatedResponse($property, 'Property updated successfully');
        } catch (\Illuminate\Validation\ValidationException $e) {
            return validationErrorResponse($e->errors());
        } catch (Exception $e) {
            return queryErrorResponse('Failed to update property', $e->getMessage());
        }
    }

    public function destroy($id)
    {
        try {
            $property = Property::find($id);
            
            if (!$property) {
                return notFoundResponse('Property not found');
            }

            DB::transaction(function () use ($property) {
                $property->delete();
            });

            return deleteResponse('Property deleted successfully');
        } catch (Exception $e) {
            return serverErrorResponse('Failed to delete property', $e->getMessage());
        }
    }
}
