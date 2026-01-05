<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    // Removed: protected $table = 'pengguna'; // Use default 'users' table

    protected $fillable = [
        'nama_lengkap',
        'email',
        'password',
        'profile_photo',
        'role',

        // STEP 2
        'nomor_telepon',
        'provinsi_kota',
        'alamat_jalan',
        'detail_lainnya',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * Check if user is admin
     */
    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }
}
