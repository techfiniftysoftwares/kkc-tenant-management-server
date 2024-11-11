<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UnitTenantPayment extends Model
{
    use HasFactory, softDeletes;
    
    protected $fillable = [
        'unit_tenant_id',
        'payment_date',
        'payment_for_month',
        'notes'
    ];

    protected $dates = [
        'payment_date',
        'payment_for_month'
    ];

    public function unitTenant()
    {
        return $this->belongsTo(UnitTenant::class);
    }
}