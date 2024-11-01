<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserLocation extends Model
{
    protected $fillable = [
        'user_id',
        'facility_id',
        'branch_id',
        'building_attribute_id'
    ];

    protected $with = ['facility', 'branch', 'buildingAttribute'];

    public function facility(): BelongsTo
    {
        return $this->belongsTo(Facility::class);
    }

    public function branch(): BelongsTo
    {
        return $this->belongsTo(Branch::class);
    }

    public function buildingAttribute(): BelongsTo
    {
        return $this->belongsTo(BuildingAttribute::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}