<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Traits\HasPermissions;
use Illuminate\Contracts\Auth\CanResetPassword;
use Illuminate\Auth\Notifications\ResetPassword;
use App\Notifications\CustomResetPasswordNotification;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\SoftDeletes;


class User extends Authenticatable implements CanResetPassword
{
    use HasApiTokens, HasFactory, HasRoles, HasPermissions, Notifiable , SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $guarded = [];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'created_at',
        'updated_at',
        'login_attempts',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function isActive(): bool
    {
        return $this->status === 'active';
    }



    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    public function hasPermission($moduleId, $submoduleId, $action)
    {
        return $this->role->permissions()
            ->where('module_id', $moduleId)
            ->where('submodule_id', $submoduleId)
            ->where('action', $action)
            ->exists();
    }






    public function propertyManager()
    {
        return $this->hasMany(PropertyManager::class);
    }

    public function activeProperties()
    {
        return $this->hasMany(PropertyManager::class)
            ->where('status', 'active')
            ->with('property');
    }

    public function isPropertyManager()
    {
        return $this->role === 'property_manager';
    }












    public function sendPasswordResetNotification($token)
    {
        // Generate a new token if not provided
        $token = $token ?: Str::random(60);

        // Store the token in the password_resets table
        DB::table('password_resets')->insert([
            'email' => $this->email,
            'token' => $token,
            'created_at' => now(),
        ]);

        // Send the password reset notification
        $this->notify(new CustomResetPasswordNotification($token));
    }
}