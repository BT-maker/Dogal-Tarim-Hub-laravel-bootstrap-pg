<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;

class AdminUser extends Model
{
    use HasFactory;

    protected $table = 'admin_users';

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'is_active',
        'last_login_at',
        'last_login_ip',
    ];

    protected $hidden = [
        'password',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'last_login_at' => 'datetime',
    ];

    /**
     * Hash the password using bcrypt after it's already been SHA-256 hashed on frontend
     *
     * @param string $hashedPassword - SHA-256 hashed password from frontend
     * @return void
     */
    public function setPasswordAttribute($hashedPassword)
    {
        $this->attributes['password'] = Hash::make($hashedPassword);
    }

    /**
     * Verify password (SHA-256 hashed from frontend against bcrypt stored in DB)
     *
     * @param string $hashedPassword - SHA-256 hashed password from frontend
     * @return bool
     */
    public function verifyPassword($hashedPassword): bool
    {
        return Hash::check($hashedPassword, $this->password);
    }

    /**
     * Update last login information
     *
     * @param string|null $ip
     * @return void
     */
    public function updateLastLogin($ip = null): void
    {
        $this->update([
            'last_login_at' => now(),
            'last_login_ip' => $ip ?? request()->ip(),
        ]);
    }

    /**
     * Check if admin is active
     *
     * @return bool
     */
    public function isActive(): bool
    {
        return $this->is_active;
    }

    /**
     * Get admin data for JWT token
     *
     * @return array
     */
    public function getJWTData(): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
            'role' => $this->role,
        ];
    }

    /**
     * Find admin by email
     *
     * @param string $email
     * @return AdminUser|null
     */
    public static function findByEmail(string $email): ?AdminUser
    {
        return static::where('email', $email)
                    ->where('is_active', true)
                    ->first();
    }
}