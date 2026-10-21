# ParkirVerse

ParkirVerse adalah aplikasi web untuk mengelola operasional parkir. Aplikasi mencatat kendaraan masuk dan keluar, menghitung biaya parkir, memantau kapasitas area, mengelola data master, dan menyajikan laporan pendapatan.

## Alur Website

1. Pengguna membuka halaman login. Halaman ini juga menampilkan ketersediaan slot area parkir.
2. Setelah login, pengguna diarahkan ke halaman sesuai role: admin, petugas, atau owner.
3. Petugas mencatat kendaraan masuk, memilih tarif dan area, lalu sistem membuat transaksi serta menampilkan karcis.
4. Saat kendaraan keluar, petugas menyelesaikan transaksi. Sistem menghitung durasi dan biaya, lalu memperbarui kapasitas area.
5. Owner memantau ringkasan operasional, pendapatan, dan laporan transaksi.
6. Admin mengelola akun pengguna dan data master yang digunakan dalam transaksi.

## Fitur Berdasarkan Role

### Admin

- Mengelola akun pengguna: tambah, ubah, dan hapus sesuai perlindungan role.
- Akun owner tidak dapat diedit atau dihapus oleh admin.
- Akun admin tidak dapat dihapus melalui fitur pengelolaan pengguna.
- Mengelola tarif parkir untuk motor, mobil, dan kategori lainnya.
- Mengelola area parkir, kapasitas, dan jumlah slot terisi.
- Mengelola data master kendaraan.
- Melihat log aktivitas pengguna.

### Petugas

- Melihat daftar kendaraan yang sedang berada di area parkir.
- Mencatat kendaraan masuk dengan nomor plat, jenis/tarif kendaraan, dan area parkir.
- Melihat ketersediaan slot dan memilih area yang masih memiliki kapasitas.
- Mencetak atau membuka kembali karcis parkir.
- Memproses kendaraan keluar; biaya dihitung dari tarif per jam dan durasi parkir.
- Melihat total pendapatan dari transaksi selesai yang tercatat atas akun petugas tersebut.

### Owner

- Melihat dashboard ringkasan pendapatan, transaksi selesai, kendaraan aktif, dan okupansi parkir.
- Melihat grafik tren pendapatan dan volume transaksi serta distribusi kendaraan.
- Memantau kapasitas area parkir dan ringkasan operasional.
- Melihat pendapatan dan jumlah transaksi selesai untuk tiap petugas; angka diperbarui melalui endpoint realtime dashboard.
- Melihat laporan transaksi selesai berdasarkan rentang tanggal, termasuk total kendaraan dan pendapatan.
- Mengunduh backup data JSON, memulihkan data dari file backup, atau menghapus data aplikasi.
- Aksi hapus data mempertahankan akun owner yang sedang digunakan agar owner tetap dapat login dan melakukan restore. Unduh backup sebelum menghapus data.

## Data yang Dikelola

- Pengguna dan role: admin, petugas, owner.
- Tarif kendaraan.
- Area parkir dan kapasitasnya.
- Data kendaraan.
- Transaksi parkir, termasuk waktu masuk/keluar, durasi, biaya, dan petugas yang mencatat transaksi.
- Log aktivitas.

## Teknologi

- Laravel 9
- PHP 8.0.2 atau lebih baru
- MySQL/MariaDB (konfigurasi koneksi tersedia di `config/database.php`)
- Blade dan Bootstrap 5

## Menjalankan Secara Lokal

1. Pasang dependensi PHP:

   ```bash
   composer install
   ```

2. Siapkan file environment dan application key:

   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

   Pada Windows Command Prompt, salin `.env.example` menjadi `.env` menggunakan `copy .env.example .env`.

3. Atur koneksi database pada `.env`, lalu buat tabel dan data awal:

   ```bash
   php artisan migrate --seed
   ```

4. Jalankan server pengembangan:

   ```bash
   php artisan serve
   ```

   Buka alamat yang ditampilkan Artisan, biasanya `http://127.0.0.1:8000`.

## Akun Awal Seeder

| Role | Username | Password |
| --- | --- | --- |
| Admin | `admin1` | `admin123` |
| Petugas | `petugas1` | `petugas123` |
| Owner | `owner1` | `owner123` |

Gunakan akun tersebut hanya untuk pengembangan lokal. Ganti password dan konfigurasi akses sebelum aplikasi digunakan di lingkungan produksi.