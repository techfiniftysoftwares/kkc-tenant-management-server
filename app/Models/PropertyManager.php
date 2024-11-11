<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PropertyManager extends Model
{
    use HasFactory, softDeletes;

    protected $fillable = [
        'user_id',
        'property_id',
        'assignment_date',
        'end_date',
        'status'
    ];

    protected $dates = [
        'assignment_date',
        'end_date'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function property()
    {
        return $this->belongsTo(Property::class);
    }
}

