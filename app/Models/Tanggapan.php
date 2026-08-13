<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tanggapan extends Model
{
    use HasFactory;

    protected $table = 'tanggapan';

    protected $fillable = [
        'pengaduan_id',
        'pengguna_id',
        'pesan',
        'status_diubah_ke',
    ];

    // Relasi: Tanggapan milik satu pengaduan
    public function pengaduan()
    {
        return $this->belongsTo(Pengaduan::class, 'pengaduan_id');
    }

    // Relasi: Tanggapan ditulis oleh satu admin
    public function pengguna()
    {
        return $this->belongsTo(User::class, 'pengguna_id');
    }
}
