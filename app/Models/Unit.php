<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Unit extends Model
{
    use HasFactory,  SoftDeletes;



    protected $fillable = [
        'property_id',
        'unit_number',
        'status',
        'rent_amount',
        'description'
    ];

    public function property()
    {
        return $this->belongsTo(Property::class);
    }

    public function tenants()
    {
        return $this->hasMany(UnitTenant::class);
    }

    public function activeTenant()
    {
        return $this->hasOne(UnitTenant::class)->where('lease_status', 'active');
    }
}