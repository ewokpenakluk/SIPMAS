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

        $infraCategory = Kategori::where('slug', 'infrastruktur-jalan')->first();
        $pelayananCategory = Kategori::where('slug', 'pelayanan-publik')->first();
        $lingkunganCategory = Kategori::where('slug', 'kebersihan-lingkungan')->first();

        // 3. Seed Sample Pengaduan
        if (Pengaduan::count() === 0) {
            // Selesai (980)
            for ($i = 1; $i <= 980; $i++) {
                Pengaduan::create([
                    'kategori_id' => $infraCategory->id ?? 1,
                    'pengguna_id' => $admin->id,
                    'nama_pelapor' => 'Warga Sagalaherang ' . $i,
                    'nik' => '32130123049500' . str_pad($i % 100, 2, '0', STR_PAD_LEFT),
                    'no_hp' => '0812345678' . str_pad($i % 100, 2, '0', STR_PAD_LEFT),
                    'alamat' => 'RT 0' . (($i % 5) + 1) . ' RW 02, Desa Sagalaherang',
                    'judul' => 'Perbaikan fasilitas jalan gang ' . $i,
                    'deskripsi' => 'Laporan perbaikan jalan yang mengalami kerusakan kecil.',
                    'status' => 'selesai',
                    'catatan_admin' => 'Telah ditindaklanjuti dan selesai dikerjakan.',
                ]);
            }

            // Dalam Proses (124)
            for ($i = 1; $i <= 124; $i++) {
                Pengaduan::create([
                    'kategori_id' => ($i % 2 == 0) ? ($pelayananCategory->id ?? 2) : ($lingkunganCategory->id ?? 3),
                    'pengguna_id' => $admin->id,
                    'nama_pelapor' => 'Warga Dusun ' . $i,
                    'nik' => '32130123049501' . str_pad($i % 100, 2, '0', STR_PAD_LEFT),
                    'no_hp' => '0812345679' . str_pad($i % 100, 2, '0', STR_PAD_LEFT),
                    'alamat' => 'Dusun Sagalaherang 2, RT 03',
                    'judul' => 'Permohonan pembersihan saluran air ' . $i,
                    'deskripsi' => 'Mohon bantuan petugas untuk pembersihan drainase.',
                    'status' => ($i % 2 == 0) ? 'diproses' : 'menunggu',
                    'catatan_admin' => ($i % 2 == 0) ? 'Tim sedang menuju lokasi.' : null,
                ]);
            }

            // Ditolak / Lainnya (141)
            for ($i = 1; $i <= 141; $i++) {
                Pengaduan::create([
                    'kategori_id' => $pelayananCategory->id ?? 2,
                    'pengguna_id' => $admin->id,
                    'nama_pelapor' => 'Masyarakat RT 04',
                    'nik' => '32130123049502' . str_pad($i % 100, 2, '0', STR_PAD_LEFT),
                    'no_hp' => '0812345680' . str_pad($i % 100, 2, '0', STR_PAD_LEFT),
                    'alamat' => 'Kecamatan Sagalaherang',
                    'judul' => 'Pengaduan Pelayanan Administrasi ' . $i,
                    'deskripsi' => 'Aspirasi terkait jam pelayanan balai desa.',
                    'status' => 'ditolak',
                    'catatan_admin' => 'Informasi kurang lengkap.',
                ]);
            }
        }
    }
}
