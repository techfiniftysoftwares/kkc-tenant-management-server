<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class Module extends Model
{
    use HasFactory;

    protected $fillable = ['name'];

    public function submodules()
    {
        return $this->hasMany(Submodule::class);
    }

    
}
