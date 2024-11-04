<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Models\Permission;

class Submodule extends Model
{
    protected $fillable = ['title',  'module_id'];

    public function module()
    {
        return $this->belongsTo(Module::class);
    }


    public function permissions()
    {
        return $this->hasMany(Permission::class, 'submodule_id');
    }
}
