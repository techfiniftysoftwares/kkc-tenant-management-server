<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Property extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'address',
        'description',
        'type',
    ];

    public function units()
    {
        return $this->hasMany(Unit::class);
    }

    public function propertyManagers()
    {
        return $this->hasMany(PropertyManager::class);
    }

    public function activePropertyManager()
    {
        return $this->hasOne(PropertyManager::class)->where('status', 'active');
    }
}


