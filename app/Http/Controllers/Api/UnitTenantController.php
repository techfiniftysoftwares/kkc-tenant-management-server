<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;

use App\Models\UnitTenant;
use App\Models\Unit;
use Illuminate\Http\Request;
use Exception;
use Illuminate\Support\Facades\DB;
use App\Models\UnitTenantPayment;

class UnitTenantController extends Controller
{
    public function index()
    {
        try {
            $leases = UnitTenant::with(['unit.property', 'tenant'])->get();
            
            if ($leases->isEmpty()) {
                return notFoundResponse('No leases found');
            }

            return successResponse('Leases retrieved successfully', $leases);
        } catch (Exception $e) {
            return serverErrorResponse('Failed to retrieve leases', $e->getMessage());
        }
    }

    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'unit_id' => 'required|exists:units,id',
                'tenant_id' => 'required|exists:tenants,id',
                'lease_start_date' => 'required|date',
                'lease_end_date' => 'nullable|date|after:lease_start_date',
                'rent_amount' => 'required|numeric|min:0',
                'security_deposit' => 'required|numeric|min:0',
                'rent_due_day' => 'required|integer|min:1|max:28',
                'lease_terms' => 'nullable|string'
            ]);

            // Check if unit is available
            $unit = Unit::find($validated['unit_id']);
            if ($unit->status !== 'vacant') {
                return errorResponse('Unit is not available for lease', 422);
            }

            DB::transaction(function () use ($validated, $unit) {
                // Create lease
                UnitTenant::create([
                    ...$validated,
                    'payment_status' => 'unpaid',
                    'lease_status' => 'active'
                ]);

                // Update unit status
                $unit->update(['status' => 'occupied']);
            });

            return createdResponse('Lease created successfully');
        } catch (\Illuminate\Validation\ValidationException $e) {
            return validationErrorResponse($e->errors());
        } catch (Exception $e) {
            return queryErrorResponse('Failed to create lease', $e->getMessage());
        }
    }

    public function show($id)
    {
        try {
            $lease = UnitTenant::with(['unit.property', 'tenant'])->find($id);
            
            if (!$lease) {
                return notFoundResponse('Lease not found');
            }

            return successResponse('Lease retrieved successfully', $lease);
        } catch (Exception $e) {
            return serverErrorResponse('Failed to retrieve lease', $e->getMessage());
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $lease = UnitTenant::find($id);
            
            if (!$lease) {
                return notFoundResponse('Lease not found');
            }

            $validated = $request->validate([
                'lease_end_date' => 'nullable|date|after:lease_start_date',
                'rent_amount' => 'numeric|min:0',
                'rent_due_day' => 'integer|min:1|max:28',
                'lease_terms' => 'nullable|string'
            ]);

            DB::transaction(function () use ($lease, $validated) {
                $lease->update($validated);
            });

            return updatedResponse($lease, 'Lease updated successfully');
        } catch (\Illuminate\Validation\ValidationException $e) {
            return validationErrorResponse($e->errors());
        } catch (Exception $e) {
            return queryErrorResponse('Failed to update lease', $e->getMessage());
        }
    }

    public function destroy($id)
    {
        try {
            $lease = UnitTenant::find($id);
            
            if (!$lease) {
                return notFoundResponse('Lease not found');
            }

            if ($lease->lease_status === 'active') {
                return errorResponse('Cannot delete active lease', 422);
            }

            DB::transaction(function () use ($lease) {
                $lease->delete();
            });

            return deleteResponse('Lease deleted successfully');
        } catch (Exception $e) {
            return serverErrorResponse('Failed to delete lease', $e->getMessage());
        }
    }

    public function updatePaymentStatus(Request $request, $id)
    {
        try {
            $lease = UnitTenant::with(['unit.property', 'tenant'])->find($id);
            
            if (!$lease) {
                return notFoundResponse('Lease not found');
            }

            $validated = $request->validate([
                'payment_status' => 'required|in:paid,unpaid,late',
                'payment_date' => 'required|date',
                'notes' => 'nullable|string'
            ]);

            DB::transaction(function () use ($lease, $validated) {
                // Update lease payment status
                $lease->update([
                    'payment_status' => $validated['payment_status'],
                    'last_payment_date' => $validated['payment_date']
                ]);

                // Create payment record if status is 'paid'
                if ($validated['payment_status'] === 'paid') {
                    UnitTenantPayment::create([
                        'unit_tenant_id' => $lease->id,
                        'payment_date' => $validated['payment_date'],
                        'payment_for_month' => date('Y-m-01'), // First day of current month
                        'notes' => $validated['notes']
                    ]);
                }
            });

            return updatedResponse($lease, 'Payment status updated successfully');
        } catch (\Illuminate\Validation\ValidationException $e) {
            return validationErrorResponse($e->errors());
        } catch (Exception $e) {
            return queryErrorResponse('Failed to update payment status', $e->getMessage());
        }
    }

    public function terminateLease(Request $request, $id)
    {
        try {
            $lease = UnitTenant::with(['unit'])->find($id);
            
            if (!$lease) {
                return notFoundResponse('Lease not found');
            }

            if ($lease->lease_status !== 'active') {
                return errorResponse('Only active leases can be terminated', 422);
            }

            $validated = $request->validate([
                'termination_date' => 'required|date',
                'termination_reason' => 'required|string',
            ]);

            DB::transaction(function () use ($lease, $validated) {
                // Update lease
                $lease->update([
                    'lease_status' => 'terminated',
                    'termination_date' => $validated['termination_date'],
                    'termination_reason' => $validated['termination_reason']
                ]);

                // Update unit status
                $lease->unit->update(['status' => 'vacant']);
            });

            return updatedResponse($lease, 'Lease terminated successfully');
        } catch (\Illuminate\Validation\ValidationException $e) {
            return validationErrorResponse($e->errors());
        } catch (Exception $e) {
            return queryErrorResponse('Failed to terminate lease', $e->getMessage());
        }
    }

    public function renewLease(Request $request, $id)
    {
        try {
            $lease = UnitTenant::find($id);
            
            if (!$lease) {
                return notFoundResponse('Lease not found');
            }

            $validated = $request->validate([
                'lease_end_date' => 'required|date|after:today',
                'rent_amount' => 'required|numeric|min:0',
                'lease_terms' => 'nullable|string'
            ]);

            DB::transaction(function () use ($lease, $validated) {
                $lease->update([
                    'lease_end_date' => $validated['lease_end_date'],
                    'rent_amount' => $validated['rent_amount'],
                    'lease_terms' => $validated['lease_terms'],
                    'lease_status' => 'active'
                ]);
            });

            return updatedResponse($lease, 'Lease renewed successfully');
        } catch (\Illuminate\Validation\ValidationException $e) {
            return validationErrorResponse($e->errors());
        } catch (Exception $e) {
            return queryErrorResponse('Failed to renew lease', $e->getMessage());
        }
    }

    public function getPaymentHistory($id)
    {
        try {
            $lease = UnitTenant::with(['payments' => function($query) {
                $query->orderBy('payment_date', 'desc');
            }])->find($id);
            
            if (!$lease) {
                return notFoundResponse('Lease not found');
            }

            return successResponse('Payment history retrieved successfully', $lease->payments);
        } catch (Exception $e) {
            return serverErrorResponse('Failed to retrieve payment history', $e->getMessage());
        }
    }

    public function getActiveLeases()
    {
        try {
            $leases = UnitTenant::with(['unit.property', 'tenant'])
                ->where('lease_status', 'active')
                ->get();

            if ($leases->isEmpty()) {
                return notFoundResponse('No active leases found');
            }

            return successResponse('Active leases retrieved successfully', $leases);
        } catch (Exception $e) {
            return serverErrorResponse('Failed to retrieve active leases', $e->getMessage());
        }
    }

    public function getOverduePayments()
    {
        try {
            $leases = UnitTenant::with(['unit.property', 'tenant'])
                ->where('lease_status', 'active')
                ->where(function($query) {
                    $query->where('payment_status', 'unpaid')
                          ->orWhere('payment_status', 'late');
                })
                ->get();

            if ($leases->isEmpty()) {
                return notFoundResponse('No overdue payments found');
            }

            return successResponse('Overdue payments retrieved successfully', $leases);
        } catch (Exception $e) {
            return serverErrorResponse('Failed to retrieve overdue payments', $e->getMessage());
        }
    }
}