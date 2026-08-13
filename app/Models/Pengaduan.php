<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pengaduan extends Model
{
    use HasFactory;

    protected $table = 'pengaduan';

    protected $fillable = [
        'nomor_tiket',
        'kategori_id',
        'pengguna_id',
        'nama_pelapor',
        'nik',
        'no_hp',
        'alamat',
        'judul',
        'deskripsi',
        'lokasi',
        'foto',
        'status',
        'catatan_admin',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($pengaduan) {
            if (empty($pengaduan->nomor_tiket)) {
                $pengaduan->nomor_tiket = self::buatNomorTiket();
            }
        });
    }

    public static function buatNomorTiket(): string
    {
        do {
            $nomor = 'ADU-' . date('Ymd') . '-' . str_pad(random_int(0, 9999), 4, '0', STR_PAD_LEFT);
        } while (self::where('nomor_tiket', $nomor)->exists());

        return $nomor;
    }

    // Relasi: Pengaduan milik satu kategori
    public function kategori()
    {
        return $this->belongsTo(Kategori::class, 'kategori_id');
    }

    // Relasi: Pengaduan ditangani oleh satu admin
    public function pengguna()
    {
        return $this->belongsTo(User::class, 'pengguna_id');
    }

    // Relasi: Pengaduan memiliki banyak tanggapan
    public function tanggapan()
    {
        return $this->hasMany(Tanggapan::class, 'pengaduan_id');
    }
}
