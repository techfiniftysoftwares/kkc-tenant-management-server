<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
use Spatie\Permission\Traits\HasPermissions;
use Illuminate\Contracts\Auth\CanResetPassword;
use App\Notifications\CustomResetPasswordNotification;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class User extends Authenticatable implements CanResetPassword
{
    use HasApiTokens, HasFactory, HasRoles, HasPermissions, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<string>
     */
    protected $fillable = [
        'firstname',
        'lastname',
        'username',
        'phone',
        'position',
        'role_id',
        'status',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<string>
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



    /**
     * Get all locations for the user
     */
    public function locations(): HasMany
    {
        return $this->hasMany(UserLocation::class);
    }

    /**
     * Get all facilities for the user through locations
     */
    public function facilities(): BelongsToMany
    {
        return $this->belongsToMany(Facility::class, 'user_locations')
                    ->withTimestamps();
    }

    /**
     * Get all branches for the user through locations
     */
    public function branches(): BelongsToMany
    {
        return $this->belongsToMany(Branch::class, 'user_locations')
                    ->withTimestamps();
    }

    /**
     * Get all building attributes for the user through locations
     */
    public function buildingAttributes(): BelongsToMany
    {
        return $this->belongsToMany(BuildingAttribute::class, 'user_locations')
                    ->withTimestamps();
    }

   
    /**
     * Other Relationships
     */
    public function assignedTools(): HasMany
    {
        return $this->hasMany(Tool::class, 'assigned_to');
    }

    public function technician(): HasOne
    {
        return $this->hasOne(Technician::class);
    }

    public function role(): BelongsTo
    {
        return $this->belongsTo(Role::class);
    }

    /**
     * Access Check Methods
     */
    public function hasAccessToFacility(int $facilityId): bool
    {
        return $this->locations()
            ->where('facility_id', $facilityId)
            ->exists();
    }

    public function hasAccessToBranch(int $branchId): bool
    {
        return $this->locations()
            ->where('branch_id', $branchId)
            ->exists();
    }

    public function hasPermission(int $moduleId, int $submoduleId, string $action): bool
    {
        return $this->role->permissions()
            ->where('module_id', $moduleId)
            ->where('submodule_id', $submoduleId)
            ->where('action', $action)
            ->exists();
    }

    /**
     * Status Check Methods
     */
    public function isActive(): bool
    {
        return $this->status === 'active';
    }

    /**
     * Password Reset Methods
     */
    public function sendPasswordResetNotification($token): void
    {
        $token = $token ?: Str::random(60);

        DB::table('password_resets')->insert([
            'email' => $this->email,
            'token' => $token,
            'created_at' => now(),
        ]);

        $this->notify(new CustomResetPasswordNotification($token));
    }
}