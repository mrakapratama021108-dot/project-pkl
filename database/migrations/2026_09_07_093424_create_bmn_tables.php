<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        // 1. Master Barang
        Schema::create('barangs', function (Blueprint $table) {
            $table->id();
            $table->string('kode_barang')->nullable();
            $table->string('nama_barang');
            $table->string('merk');
            $table->string('tipe');
            $table->integer('stok');
            $table->timestamps();
        });

        // 2. Master Buku PAUDPEDIA (Penting: Harus dibuat sebelum pengajuan_bukus)
        Schema::create('bukus', function (Blueprint $table) {
            $table->id();
            $table->string('judul');
            $table->integer('stok');
            $table->timestamps();
        });

        // 3. Transaksi Peminjaman BMN
        Schema::create('peminjamans', function (Blueprint $table) {
            $table->id();
            $table->string('pegawai');
            $table->foreignId('barang_id')->constrained('barangs')->onDelete('cascade');
            $table->integer('jumlah');
            $table->enum('status', [
                'menunggu_review', 
                'tertahan', 
                'menunggu_approval', 
                'dipinjam', 
                'ditolak', 
                'menunggu_rilis_pengembalian', 
                'selesai'
            ])->default('menunggu_review');
            $table->text('catatan')->nullable();
            $table->timestamps();
        });

        // 4. Modul Perbaikan BMN
        Schema::create('perbaikans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('barang_id')->constrained('barangs')->onDelete('cascade');
            $table->text('keluhan');
            $table->boolean('bisa_diperbaiki')->nullable();
            $table->enum('status', ['menunggu_reviewer', 'proses', 'rusak_final', 'selesai'])->default('menunggu_reviewer');
            $table->timestamps();
        });

        // 5. Modul Pengajuan Buku
        Schema::create('pengajuan_bukus', function (Blueprint $table) {
            $table->id();
            $table->string('pemohon')->default('Pegawai');
            $table->foreignId('buku_id')->constrained('bukus')->onDelete('cascade');
            $table->integer('jumlah');
            $table->enum('metode', ['ambil', 'kirim']);
            $table->text('alamat')->nullable();
            $table->enum('status', ['diproses', 'siap_ambil', 'siap_kirim', 'selesai'])->default('diproses');
            $table->timestamps();
        });

        // 6. Modul Laporan Kehilangan
        Schema::create('laporan_hilangs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('peminjaman_id')->constrained('peminjamans')->onDelete('cascade');
            $table->enum('status', ['menunggu_acc', 'hilang_close'])->default('menunggu_acc');
            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('laporan_hilangs');
        Schema::dropIfExists('pengajuan_bukus');
        Schema::dropIfExists('perbaikans');
        Schema::dropIfExists('peminjamans');
        Schema::dropIfExists('bukus');
        Schema::dropIfExists('barangs');
    }
};