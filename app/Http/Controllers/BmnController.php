<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\Buku;
use App\Models\Peminjaman;
use App\Models\Perbaikan;
use App\Models\PengajuanBuku;
use App\Models\LaporanHilang;
use Illuminate\Http\Request;

class BmnController extends Controller
{
    public function index(Request $request)
    {
        $role = $request->get('role', 'Pegawai');
        $tab = $request->get('tab', 'master');

        $masterBarang = Barang::all();
        $masterBuku = Buku::all();
        $peminjaman = Peminjaman::with('barang')->latest()->get();
        $perbaikan = Perbaikan::with('barang')->latest()->get();
        $pengajuanBuku = PengajuanBuku::with('buku')->latest()->get();
        $laporanHilang = LaporanHilang::with('peminjaman.barang')->latest()->get();

        return view('bmn.index', compact(
            'role', 'tab', 'masterBarang', 'masterBuku', 
            'peminjaman', 'perbaikan', 'pengajuanBuku', 'laporanHilang'
        ));
    }

    // --- MASTER DATA LOGIC ---
    public function tambahBarang(Request $request)
    {
        $existing = Barang::whereRaw('LOWER(merk) = ?', [strtolower($request->merk)])
            ->whereRaw('LOWER(tipe) = ?', [strtolower($request->tipe)])
            ->first();

        if ($existing) {
            $existing->increment('stok', $request->jumlah);
        } else {
            Barang::create([
                'kode_barang' => $request->kode_barang,
                'nama_barang' => $request->nama,
                'merk' => $request->merk,
                'tipe' => $request->tipe,
                'stok' => $request->jumlah,
            ]);
        }
        return back()->with('success', 'Master barang diperbarui!');
    }

    public function tambahBuku(Request $request)
    {
        $existing = Buku::whereRaw('LOWER(judul) = ?', [strtolower($request->judul)])->first();

        if ($existing) {
            $existing->increment('stok', $request->jumlah);
        } else {
            Buku::create([
                'judul' => $request->judul,
                'stok' => $request->jumlah,
            ]);
        }
        return back()->with('success', 'Master buku diperbarui!');
    }

    // --- PEMINJAMAN LOGIC ---
    public function ajukanPeminjaman(Request $request)
    {
        Peminjaman::create([
            'pegawai' => $request->pegawai,
            'barang_id' => $request->barang_id,
            'jumlah' => $request->jumlah,
            'status' => 'menunggu_review',
        ]);
        return back()->with('success', 'Pengajuan peminjaman berhasil dibuat!');
    }

    public function reviewPeminjaman($id)
    {
        $loan = Peminjaman::findOrFail($id);
        
        $punyaPinjamanAktif = Peminjaman::where('pegawai', $loan->pegawai)
            ->where('status', 'dipinjam')
            ->where('id', '!=', $id)
            ->exists();

        $loan->update([
            'status' => $punyaPinjamanAktif ? 'tertahan' : 'menunggu_approval',
            'catatan' => $punyaPinjamanAktif ? 'Harus kembalikan pinjaman lain dulu' : null,
        ]);

        return back()->with('success', 'Peminjaman telah direview!');
    }

    public function approvePeminjaman(Request $request, $id)
    {
        $loan = Peminjaman::findOrFail($id);
        
        if ($request->disetujui) {
            $barang = Barang::findOrFail($loan->barang_id);
            if ($barang->stok < $loan->jumlah) {
                return back()->with('error', 'Stok barang tidak cukup!');
            }
            $barang->decrement('stok', $loan->jumlah);
            $loan->update(['status' => 'dipinjam']);
        } else {
            $loan->update(['status' => 'ditolak']);
        }

        return back()->with('success', 'Keputusan approval berhasil disimpan!');
    }

    // --- PENGEMBALIAN LOGIC ---
    public function ajukanPengembalian($id)
    {
        Peminjaman::findOrFail($id)->update(['status' => 'menunggu_rilis_pengembalian']);
        return back()->with('success', 'Pengajuan pengembalian dikirim!');
    }

    public function rilisPengembalian($id)
    {
        $loan = Peminjaman::findOrFail($id);
        Barang::findOrFail($loan->barang_id)->increment('stok', $loan->jumlah);
        $loan->update(['status' => 'selesai']);

        return back()->with('success', 'Barang dikembalikan & BAST terbit!');
    }

    // --- PERBAIKAN LOGIC ---
    public function ajukanPerbaikan(Request $request)
    {
        Perbaikan::create([
            'barang_id' => $request->barang_id,
            'keluhan' => $request->keluhan,
            'status' => 'menunggu_reviewer',
        ]);
        return back()->with('success', 'Laporan perbaikan dikirim!');
    }

    public function putuskanPerbaikan(Request $request, $id)
    {
        $p = Perbaikan::findOrFail($id);
        $bisa = $request->bisa_diperbaiki;

        $p->update([
            'bisa_diperbaiki' => $bisa,
            'status' => $bisa ? 'proses' : 'rusak_final',
        ]);

        if (!$bisa) {
            $barang = Barang::findOrFail($p->barang_id);
            if ($barang->stok > 0) {
                $barang->decrement('stok', 1);
            }
        }

        return back()->with('success', 'Status perbaikan diperbarui!');
    }

    public function selesaikanPerbaikan($id)
    {
        Perbaikan::findOrFail($id)->update(['status' => 'selesai']);
        return back()->with('success', 'Perbaikan diselesaikan!');
    }

    // --- PENGAJUAN BUKU LOGIC ---
    public function ajukanBuku(Request $request)
    {
        PengajuanBuku::create([
            'buku_id' => $request->buku_id,
            'jumlah' => $request->jumlah,
            'metode' => $request->metode,
            'status' => 'diprosos',
        ]);
        return back()->with('success', 'Pengajuan buku terkirim!');
    }

    public function prosesPengajuanBuku($id)
    {
        $p = PengajuanBuku::findOrFail($id);
        Buku::findOrFail($p->buku_id)->decrement('stok', $p->jumlah);
        
        $p->update([
            'status' => $p->metode === 'ambil' ? 'siap_ambil' : 'siap_kirim',
        ]);

        return back()->with('success', 'Pengajuan buku diproses!');
    }

    public function selesaikanPengajuanBuku($id)
    {
        PengajuanBuku::findOrFail($id)->update(['status' => 'selesai']);
        return back()->with('success', 'Pengajuan buku selesai!');
    }

    // --- LAPORAN KEHILANGAN LOGIC ---
    public function laporkanHilang($id)
    {
        LaporanHilang::create([
            'peminjaman_id' => $id,
            'status' => 'menunggu_acc',
        ]);
        return back()->with('success', 'Laporan kehilangan dibuat!');
    }

    public function accKehilangan($id)
    {
        $lap = LaporanHilang::findOrFail($id);
        $lap->peminjaman->update(['status' => 'selesai']);
        $lap->update(['status' => 'hilang_close']);

        return back()->with('success', 'Laporan kehilangan di-ACC dan ditutup!');
    }

    // --- DUA METHOD HAPUS DITAROH DI SINI (BAGIAN PALING BAWAH) ---
    public function hapusBarang($id)
    {
        Barang::findOrFail($id)->delete();
        return back()->with('success', 'Barang BMN berhasil dihapus!');
    }

    public function hapusBuku($id)
    {
        Buku::findOrFail($id)->delete();
        return back()->with('success', 'Buku berhasil dihapus!');
    }
}