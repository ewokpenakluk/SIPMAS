<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Kategori;
use App\Models\Pengaduan;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Seed User Admin
        $admin = User::firstOrCreate(
            ['nik' => '3213010101900001'],
            [
                'nama' => 'Admin Desa Sagalaherang',
                'email' => 'admin@sagalaherang.desa.id',
                'no_hp' => '081234567890',
                'alamat' => 'Kantor Desa Sagalaherang',
                'password' => bcrypt('admin123'),
                'peran' => 'superadmin',
            ]
        );

        // 2. Seed Kategori Pengaduan
        $categories = [
            ['nama' => 'Infrastruktur & Jalan', 'slug' => 'infrastruktur-jalan', 'ikon' => 'road'],
            ['nama' => 'Pelayanan Publik', 'slug' => 'pelayanan-publik', 'ikon' => 'users'],
            ['nama' => 'Kebersihan & Lingkungan', 'slug' => 'kebersihan-lingkungan', 'ikon' => 'tree'],
            ['nama' => 'Keamanan & Ketertiban', 'slug' => 'keamanan-ketertiban', 'ikon' => 'shield-check'],
            ['nama' => 'Kesehatan', 'slug' => 'kesehatan', 'ikon' => 'heart-pulse'],
            ['nama' => 'Lainnya', 'slug' => 'lainnya', 'ikon' => 'grid'],
        ];

        foreach ($categories as $cat) {
            Kategori::firstOrCreate(['slug' => $cat['slug']], $cat);
        }
    }
}
