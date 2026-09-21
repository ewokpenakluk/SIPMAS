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
        'foto_profil',
        'peran',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    public function getFotoProfilUrlAttribute(): string
    {
        if ($this->foto_profil && \Storage::disk('public')->exists($this->foto_profil)) {
            return asset('storage/' . $this->foto_profil);
        }
        return 'https://ui-avatars.com/api/?name=' . urlencode($this->nama) . '&background=06612B&color=fff&size=256';
    }

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
