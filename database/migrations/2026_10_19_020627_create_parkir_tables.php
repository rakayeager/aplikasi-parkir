<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // 1. tb_user (Induk)
        Schema::create('tb_user', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id_user');
            $table->string('nama_lengkap', 50);
            $table->string('username', 50)->unique();
            $table->string('password', 100);
            $table->enum('role', ['admin', 'petugas', 'owner']);
            $table->tinyInteger('status_aktif')->default(1);
            $table->rememberToken();
            $table->timestamps();
        });

        // 2. tb_tarif (Induk)
        Schema::create('tb_tarif', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id_tarif');
            $table->enum('jenis_kendaraan', ['motor', 'mobil', 'lainnya']);
            $table->decimal('tarif_per_jam', 10, 0);
            $table->timestamps();
        });

        // 3. tb_area_parkir (Induk)
        Schema::create('tb_area_parkir', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id_area');
            $table->string('nama_area', 50);
            $table->integer('kapasitas');
            $table->integer('terisi')->default(0);
            $table->timestamps();
        });

        // 4. tb_kendaraan
        Schema::create('tb_kendaraan', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id_kendaraan');
            $table->string('plat_nomor', 15);
            $table->string('jenis_kendaraan', 20);
            $table->string('warna', 20)->nullable();
            $table->string('pemilik', 100)->nullable();
            $table->unsignedInteger('id_user');
            $table->timestamps();

            $table->foreign('id_user')->references('id_user')->on('tb_user')->onDelete('cascade');
        });

        // 5. tb_transaksi
        Schema::create('tb_transaksi', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id_parkir');
            $table->unsignedInteger('id_kendaraan');
            $table->dateTime('waktu_masuk');
            $table->dateTime('waktu_keluar')->nullable();
            $table->unsignedInteger('id_tarif');
            $table->integer('durasi_jam')->nullable();
            $table->decimal('biaya_total', 10, 0)->nullable();
            $table->enum('status', ['masuk', 'keluar'])->default('masuk');
            $table->unsignedInteger('id_user');
            $table->unsignedInteger('id_area');
            $table->timestamps();

            $table->foreign('id_kendaraan')->references('id_kendaraan')->on('tb_kendaraan')->onDelete('cascade');
            $table->foreign('id_tarif')->references('id_tarif')->on('tb_tarif')->onDelete('cascade');
            $table->foreign('id_user')->references('id_user')->on('tb_user')->onDelete('cascade');
            $table->foreign('id_area')->references('id_area')->on('tb_area_parkir')->onDelete('cascade');
        });

        // 6. tb_log_aktivitas
        Schema::create('tb_log_aktivitas', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id_log');
            $table->unsignedInteger('id_user');
            $table->string('aktivitas', 100);
            $table->dateTime('waktu_aktivitas')->useCurrent();
            $table->timestamps();

            $table->foreign('id_user')->references('id_user')->on('tb_user')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tb_log_aktivitas');
        Schema::dropIfExists('tb_transaksi');
        Schema::dropIfExists('tb_kendaraan');
        Schema::dropIfExists('tb_area_parkir');
        Schema::dropIfExists('tb_tarif');
        Schema::dropIfExists('tb_user');
    }
};