<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BmnController;
use App\Http\Controllers\AuthController;
use App\Http\Middleware\CheckRole;

// Route Auth (Hanya untuk guest / belum login)
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.post');

    // Route Fitur Reset Password
    Route::get('/forgot-password', [AuthController::class, 'showForgotPassword'])->name('password.request');
    Route::post('/forgot-password', [AuthController::class, 'sendResetLinkEmail'])->name('password.email');
    Route::get('/reset-password/{token}', [AuthController::class, 'showResetPassword'])->name('password.reset');
    Route::post('/reset-password', [AuthController::class, 'resetPassword'])->name('password.update');
});

// Logout
Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

// Halaman Dashboard & Fitur Utama (Wajib Login)
Route::middleware('auth')->group(function () {
    Route::get('/', [BmnController::class, 'index'])->name('bmn.index');

    // ROUTE CETAK DOKUMEN & REKAP (Dapat diakses oleh semua user terautentikasi)
    Route::get('/bmn/peminjaman/{id}/bast', [BmnController::class, 'cetakBastPeminjaman'])->name('bmn.peminjaman.bast');
    Route::get('/bmn/pengembalian/{id}/bast', [BmnController::class, 'cetakBastPengembalian'])->name('bmn.pengembalian.bast');
    Route::get('/bmn/laporan-6bulan/cetak', [BmnController::class, 'cetakLaporan6Bulan'])->name('bmn.laporan6bulan.cetak');

    // Khusus Pegawai
    Route::middleware([CheckRole::class . ':Pegawai'])->group(function () {
        Route::post('/bmn/peminjaman/ajukan', [BmnController::class, 'ajukanPeminjaman'])->name('bmn.peminjaman.ajukan');
        Route::patch('/bmn/pengembalian/{id}/ajukan', [BmnController::class, 'ajukanPengembalian'])->name('bmn.pengembalian.ajukan');
        Route::post('/bmn/perbaikan/ajukan', [BmnController::class, 'ajukanPerbaikan'])->name('bmn.perbaikan.ajukan');
        Route::post('/bmn/buku/ajukan', [BmnController::class, 'ajukanBuku'])->name('bmn.buku.ajukan');
        Route::post('/bmn/hilang/{id}/laporkan', [BmnController::class, 'laporkanHilang'])->name('bmn.hilang.laporkan');
        Route::post('/bmn/laporan-6bulan', [BmnController::class, 'simpanLaporan6Bulan'])->name('bmn.laporan6bulan.simpan');
    });

    // Khusus Reviewer (Tim BMN)
    Route::middleware([CheckRole::class . ':Reviewer (Tim BMN)'])->group(function () {
        Route::post('/bmn/barang/tambah', [BmnController::class, 'tambahBarang'])->name('bmn.barang.tambah');
        Route::delete('/bmn/barang/{id}/hapus', [BmnController::class, 'hapusBarang'])->name('bmn.barang.hapus');
        Route::post('/bmn/buku/tambah', [BmnController::class, 'tambahBuku'])->name('bmn.buku.tambah');
        Route::delete('/bmn/buku/{id}/hapus', [BmnController::class, 'hapusBuku'])->name('bmn.buku.hapus');
        Route::patch('/bmn/peminjaman/{id}/review', [BmnController::class, 'reviewPeminjaman'])->name('bmn.peminjaman.review');
        Route::patch('/bmn/pengembalian/{id}/rilis', [BmnController::class, 'rilisPengembalian'])->name('bmn.pengembalian.rilis');
        Route::post('/bmn/peminjaman/{id}/kembalikan', [BmnController::class, 'kembalikanBarang'])->name('bmn.peminjaman.kembalikan');
        Route::patch('/bmn/perbaikan/{id}/putuskan', [BmnController::class, 'putuskanPerbaikan'])->name('bmn.perbaikan.putuskan');
        Route::patch('/bmn/perbaikan/{id}/selesai', [BmnController::class, 'selesaikanPerbaikan'])->name('bmn.perbaikan.selesai');
        Route::patch('/bmn/buku/{id}/proses', [BmnController::class, 'prosesPengajuanBuku'])->name('bmn.buku.proses');
        Route::patch('/bmn/buku/{id}/selesai', [BmnController::class, 'selesaikanPengajuanBuku'])->name('bmn.buku.selesai');
        Route::patch('/bmn/hilang/{id}/acc', [BmnController::class, 'accKehilangan'])->name('bmn.hilang.acc');
    });

    // Khusus Approver (Kasubag TU)
    Route::middleware([CheckRole::class . ':Approver (Kasubag TU)'])->group(function () {
        Route::patch('/bmn/peminjaman/{id}/approve', [BmnController::class, 'approvePeminjaman'])->name('bmn.peminjaman.approve');
    });
});