<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'phone',
        'password',
        'role',
        'is_blocked',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the orders for the user.
     */
    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function hasRole(string $role): bool
    {
        return (string) $this->role === $role;
    }

    public function hasAnyRole(array $roles): bool
    {
        return in_array((string) $this->role, $roles, true);
    }

    public function hasAdminPermission(string $permission): bool
    {
        if ($this->hasRole('admin')) {
            return true;
        }

        $permissions = config('admin_permissions.roles.' . $this->role, []);
        if (!is_array($permissions)) {
            return false;
        }

        if (in_array($permission, $permissions, true)) {
            return true;
        }

        foreach ($permissions as $grantedPermission) {
            if (!is_string($grantedPermission) || !str_ends_with($grantedPermission, '.*')) {
                continue;
            }

            $prefix = substr($grantedPermission, 0, -2);
            if ($prefix !== '' && str_starts_with($permission, $prefix . '.')) {
                return true;
            }
        }

        return false;
    }

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
}
