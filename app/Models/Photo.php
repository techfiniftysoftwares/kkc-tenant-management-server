<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Photo extends Model
{
    use HasFactory;

    protected $fillable = [
        'asset_id',
        'file_path',

    ];

    public function asset()
    {
        return $this->belongsTo(Asset::class);
    }

}
