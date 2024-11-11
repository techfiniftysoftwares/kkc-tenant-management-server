<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UnitTenant extends Model
{
    use HasFactory, SoftDeletes;
    

    protected $fillable = [
        'unit_id',
        'tenant_id',
        'lease_start_date',
        'lease_end_date',
        'rent_amount',
        'security_deposit',
        'rent_due_day',
        'payment_status',
        'last_payment_date',
        'lease_status',
        'lease_terms',
        'termination_reason',
        'termination_date'
    ];

    protected $dates = [
        'lease_start_date',
        'lease_end_date',
        'last_payment_date',
        'termination_date'
    ];

    public function unit()
    {
        return $this->belongsTo(Unit::class);
    }

    public function tenant()
    {
        return $this->belongsTo(Tenant::class);
    }

    public function payments()
    {
        return $this->hasMany(UnitTenantPayment::class);
    }

    public function isLeaseExpired()
    {
        if (!$this->lease_end_date) {
            return false;
        }
        return now()->startOfDay()->gt($this->lease_end_date);
    }

    public function isRentOverdue()
    {
        if ($this->payment_status === 'paid') {
            return false;
        }

        $dueDate = now()->setDay($this->rent_due_day)->startOfDay();
        if (now()->day > $this->rent_due_day) {
            $dueDate->subMonth();
        }

        return now()->startOfDay()->gt($dueDate);
    }
}

