<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $table = 'pengguna';

    protected $fillable = [
        'nama',
        'email',
        'nik',
        'no_hp',
        'alamat',
        'password',
        'peran',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    // Relasi: User/Admin menangani banyak pengaduan
    public function pengaduan()
    {
        return $this->hasMany(Pengaduan::class, 'pengguna_id');
    }

    // Relasi: User/Admin memiliki banyak tanggapan
    public function tanggapan()
    {
        return $this->hasMany(Tanggapan::class, 'pengguna_id');
    }

    public function isWarga(): bool
    {
        return $this->peran === 'warga';
    }

    public function isAdmin(): bool
    {
        return $this->peran === 'admin' || $this->peran === 'superadmin';
    }

    public function isSuperAdmin(): bool
    {
        return $this->peran === 'superadmin';
    }
}
