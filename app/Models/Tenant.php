<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Tenant extends Model
{
    use HasFactory, SoftDeletes;
    
        protected $fillable = [
            'first_name',
            'last_name',
            'email',
            'phone',
            'emergency_contact_name',
            'emergency_contact_phone',
            'id_number',
            'address_history',
            'employment_details'
        ];
    
        public function units()
        {
            return $this->hasMany(UnitTenant::class);
        }
    
        public function activeLeases()
        {
            return $this->hasMany(UnitTenant::class)->where('lease_status', 'active');
        }
    
        public function getFullNameAttribute()
        {
            return "{$this->first_name} {$this->last_name}";
        }
    }
