<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;

use App\Models\Property;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Exception;

class PropertyController extends Controller
{
    public function index()
    {
        try {
            $properties = Property::all();

            if ($properties->isEmpty()) {
                return notFoundResponse('No properties found');
            }

            return successResponse('Properties retrieved successfully', $properties);
        } catch (Exception $e) {
            return queryErrorResponse('Failed to retrieve properties', $e->getMessage());
        }
    }

    public function store(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'name' => 'required|string|max:255',
                'type' => 'required|in:house,apartment,commercial,land',
                'address' => 'required|string|max:255',
                'description' => 'nullable|string'
            ]);

            if ($validator->fails()) {
                return validationErrorResponse($validator->errors());
            }

            $property = Property::create($request->all());
            return successResponse('Property created successfully', $property, 201);
        } catch (Exception $e) {
            return serverErrorResponse('Failed to create property', $e->getMessage());
        }
    }

    public function show($id)
    {
        try {
            $property = Property::find($id);

            if (!$property) {
                return notFoundResponse('Property not found');
            }

            return successResponse('Property retrieved successfully', $property);
        } catch (Exception $e) {
            return queryErrorResponse('Failed to retrieve property', $e->getMessage());
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $property = Property::find($id);

            if (!$property) {
                return notFoundResponse('Property not found');
            }

            $validator = Validator::make($request->all(), [
                'name' => 'string|max:255',
                'type' => 'in:house,apartment,commercial,land',
                'address' => 'string|max:255',
                'description' => 'nullable|string'
            ]);

            if ($validator->fails()) {
                return validationErrorResponse($validator->errors());
            }

            $property->update($request->all());
            return updatedResponse($property, 'Property updated successfully');
        } catch (Exception $e) {
            return serverErrorResponse('Failed to update property', $e->getMessage());
        }
    }

    public function destroy($id)
    {
        try {
            $property = Property::find($id);

            if (!$property) {
                return notFoundResponse('Property not found');
            }

            $property->delete();
            return deleteResponse('Property deleted successfully');
        } catch (Exception $e) {
            return serverErrorResponse('Failed to delete property', $e->getMessage());
        }
    }
}
