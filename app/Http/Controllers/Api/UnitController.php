<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\Models\Unit;
use Illuminate\Http\Request;
use Exception;

class UnitController extends Controller
{
    public function index()
    {
        try {
            $units = Unit::with(['property', 'activeTenant.tenant'])->get();
            
            if ($units->isEmpty()) {
                return notFoundResponse('No units found');
            }

            return successResponse('Units retrieved successfully', $units);
        } catch (Exception $e) {
            return serverErrorResponse('Failed to retrieve units', $e->getMessage());
        }
    }

    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'property_id' => 'required|exists:properties,id',
                'unit_number' => 'required|string|max:255',
                'status' => 'required|in:vacant,occupied,maintenance,reserved',
                'rent_amount' => 'required|numeric|min:0',
                'bedrooms' => 'nullable|integer|min:0',
                'bathrooms' => 'nullable|integer|min:0',
                'square_footage' => 'nullable|numeric|min:0',
                'description' => 'nullable|string'
            ]);

            $unit = DB::transaction(function () use ($validated) {
                return Unit::create($validated);
            });

            return createdResponse('Unit created successfully');
        } catch (\Illuminate\Validation\ValidationException $e) {
            return validationErrorResponse($e->errors());
        } catch (Exception $e) {
            return queryErrorResponse('Failed to create unit', $e->getMessage());
        }
    }

    public function show($id)
    {
        try {
            $unit = Unit::with(['property', 'activeTenant.tenant'])->find($id);
            
            if (!$unit) {
                return notFoundResponse('Unit not found');
            }

            return successResponse('Unit retrieved successfully', $unit);
        } catch (Exception $e) {
            return serverErrorResponse('Failed to retrieve unit', $e->getMessage());
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $unit = Unit::find($id);
            
            if (!$unit) {
                return notFoundResponse('Unit not found');
            }

            $validated = $request->validate([
                'unit_number' => 'string|max:255',
                'status' => 'in:vacant,occupied,maintenance,reserved',
                'rent_amount' => 'numeric|min:0',
                'bedrooms' => 'nullable|integer|min:0',
                'bathrooms' => 'nullable|integer|min:0',
                'square_footage' => 'nullable|numeric|min:0',
                'description' => 'nullable|string'
            ]);

            DB::transaction(function () use ($unit, $validated) {
                $unit->update($validated);
            });

            return updatedResponse($unit, 'Unit updated successfully');
        } catch (\Illuminate\Validation\ValidationException $e) {
            return validationErrorResponse($e->errors());
        } catch (Exception $e) {
            return queryErrorResponse('Failed to update unit', $e->getMessage());
        }
    }

    public function destroy($id)
    {
        try {
            $unit = Unit::find($id);
            
            if (!$unit) {
                return notFoundResponse('Unit not found');
            }

            DB::transaction(function () use ($unit) {
                $unit->delete();
            });

            return deleteResponse('Unit deleted successfully');
        } catch (Exception $e) {
            return serverErrorResponse('Failed to delete unit', $e->getMessage());
        }
    }
}