<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BmnController;

Route::get('/', [BmnController::class, 'index'])->name('bmn.index');

// Master Data
Route::post('/bmn/barang/tambah', [BmnController::class, 'tambahBarang'])->name('bmn.barang.tambah');
Route::post('/bmn/buku/tambah', [BmnController::class, 'tambahBuku'])->name('bmn.buku.tambah');

// Peminjaman
Route::post('/bmn/peminjaman/ajukan', [BmnController::class, 'ajukanPeminjaman'])->name('bmn.peminjaman.ajukan');
Route::patch('/bmn/peminjaman/{id}/review', [BmnController::class, 'reviewPeminjaman'])->name('bmn.peminjaman.review');
Route::patch('/bmn/peminjaman/{id}/approve', [BmnController::class, 'approvePeminjaman'])->name('bmn.peminjaman.approve');

// Pengembalian
Route::patch('/bmn/pengembalian/{id}/ajukan', [BmnController::class, 'ajukanPengembalian'])->name('bmn.pengembalian.ajukan');
Route::patch('/bmn/pengembalian/{id}/rilis', [BmnController::class, 'rilisPengembalian'])->name('bmn.pengembalian.rilis');

// Perbaikan
Route::post('/bmn/perbaikan/ajukan', [BmnController::class, 'ajukanPerbaikan'])->name('bmn.perbaikan.ajukan');
Route::patch('/bmn/perbaikan/{id}/putuskan', [BmnController::class, 'putuskanPerbaikan'])->name('bmn.perbaikan.putuskan');
Route::patch('/bmn/perbaikan/{id}/selesai', [BmnController::class, 'selesaikanPerbaikan'])->name('bmn.perbaikan.selesai');

// Buku
Route::post('/bmn/buku/ajukan', [BmnController::class, 'ajukanBuku'])->name('bmn.buku.ajukan');
Route::patch('/bmn/buku/{id}/proses', [BmnController::class, 'prosesPengajuanBuku'])->name('bmn.buku.proses');
Route::patch('/bmn/buku/{id}/selesai', [BmnController::class, 'selesaikanPengajuanBuku'])->name('bmn.buku.selesai');

//Hapus Data
Route::delete('/bmn/barang/{id}/hapus', [BmnController::class, 'hapusBarang'])->name('bmn.barang.hapus');
Route::delete('/bmn/buku/{id}/hapus', [BmnController::class, 'hapusBuku'])->name('bmn.buku.hapus');

// Kehilangan
Route::post('/bmn/hilang/{id}/laporkan', [BmnController::class, 'laporkanHilang'])->name('bmn.hilang.laporkan');
Route::patch('/bmn/hilang/{id}/acc', [BmnController::class, 'accKehilangan'])->name('bmn.hilang.acc');