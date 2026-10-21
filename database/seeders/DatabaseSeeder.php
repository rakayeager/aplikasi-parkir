<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // User awal: password seragam 'password123'
        DB::table('tb_user')->insert([
            [
                'id_user' => 1,
                'nama_lengkap' => 'Budi Santoso',
                'username' => 'admin1',
                'password' => Hash::make('admin123'),
                'role' => 'admin',
                'status_aktif' => 1,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'id_user' => 2,
                'nama_lengkap' => 'Siti Aminah',
                'username' => 'petugas1',
                'password' => Hash::make('petugas123'),
                'role' => 'petugas',
                'status_aktif' => 1,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'id_user' => 3,
                'nama_lengkap' => 'Pak Hendra',
                'username' => 'owner1',
                'password' => Hash::make('owner123'),
                'role' => 'owner',
                'status_aktif' => 1,
                'created_at' => now(),
                'updated_at' => now()
            ]
        ]);

        // Data Tarif
        DB::table('tb_tarif')->insert([
            ['id_tarif' => 1, 'jenis_kendaraan' => 'motor', 'tarif_per_jam' => 2000, 'created_at' => now(), 'updated_at' => now()],
            ['id_tarif' => 2, 'jenis_kendaraan' => 'mobil', 'tarif_per_jam' => 5000, 'created_at' => now(), 'updated_at' => now()],
            ['id_tarif' => 3, 'jenis_kendaraan' => 'lainnya', 'tarif_per_jam' => 3000, 'created_at' => now(), 'updated_at' => now()]
        ]);

        // Data Area Parkir
        DB::table('tb_area_parkir')->insert([
            ['id_area' => 1, 'nama_area' => 'Area A - Motor', 'kapasitas' => 50, 'terisi' => 0, 'created_at' => now(), 'updated_at' => now()],
            ['id_area' => 2, 'nama_area' => 'Area B - Mobil', 'kapasitas' => 30, 'terisi' => 0, 'created_at' => now(), 'updated_at' => now()]
        ]);
    }
}