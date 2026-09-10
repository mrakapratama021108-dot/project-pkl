<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\Buku;
use App\Models\Peminjaman;
use App\Models\Perbaikan;
use App\Models\PengajuanBuku;
use App\Models\LaporanHilang;
use App\Models\LaporanEnamBulan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; 
use Barryvdh\DomPDF\Facade\Pdf; // Package DomPDF untuk ekspor PDF

class BmnController extends Controller
{
    public function index(Request $request)
    {
        $role = Auth::user()->role; 
        $tab = $request->get('tab', 'master');

        $masterBarang = Barang::all();
        $masterBuku = Buku::all();
        $peminjaman = Peminjaman::with('barang')->latest()->get();
        $perbaikan = Perbaikan::with('barang')->latest()->get();
        $pengajuanBuku = PengajuanBuku::with('buku')->latest()->get();
        $laporanHilang = LaporanHilang::with('peminjaman.barang')->latest()->get();
        $laporan6Bulan = LaporanEnamBulan::with('peminjaman.barang')->latest()->get();

        return view('bmn.index', compact(
            'role', 'tab', 'masterBarang', 'masterBuku', 
            'peminjaman', 'perbaikan', 'pengajuanBuku', 'laporanHilang', 'laporan6Bulan'
        ));
    }

    // --- CETAK DOKUMEN & BAST LOGIC ---
    public function cetakBastPeminjaman($id)
    {
        $peminjaman = Peminjaman::with('barang')->findOrFail($id);
        return view('bmn.bast_peminjaman', compact('peminjaman'));
    }

    public function cetakBastPengembalian($id)
    {
        $peminjaman = Peminjaman::with('barang')->findOrFail($id);
        return view('bmn.bast_pengembalian', compact('peminjaman'));
    }

    // --- CETAK LAPORAN 6 BULANAN (PDF) ---
    public function cetakLaporan6Bulan(Request $request)
    {
        $periode = 'Semester ' . (date('n') <= 6 ? '1' : '2') . ' ' . date('Y');
        $laporan = LaporanEnamBulan::with('peminjaman.barang')->latest()->get();

        // Meng-generate file PDF dari view Blade
        $pdf = Pdf::loadView('bmn.cetak_laporan_6bulan', compact('laporan', 'periode'))
                  ->setPaper('a4', 'portrait');

        // Mengunduh langsung file PDF
        return $pdf->download('Laporan_6_Bulanan_BMN_' . str_replace(' ', '_', $periode) . '.pdf');
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
            ->where('barang_id', $loan->barang_id)
            ->where('status', 'dipinjam')
            ->where('id', '!=', $id)
            ->exists();

        $loan->update([
            'status' => $punyaPinjamanAktif ? 'tertahan' : 'menunggu_approval',
            'catatan' => $punyaPinjamanAktif ? 'Masih meminjam unit barang yang sama. Kembalikan terlebih dahulu.' : null,
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
        $loan = Peminjaman::findOrFail($id);
        $loan->update(['status' => 'menunggu_rilis_pengembalian']);
        return back()->with('success', 'Pengajuan pengembalian barang berhasil dikirim!');
    }

    public function rilisPengembalian(Request $request, $id)
    {
        $request->validate([
            'kondisi_kembali' => 'required|string',
            'catatan_kembali' => 'nullable|string',
        ]);

        $loan = Peminjaman::findOrFail($id);
        $loan->update([
            'status' => 'selesai',
            'kondisi_kembali' => $request->kondisi_kembali,
            'catatan_kembali' => $request->catatan_kembali,
        ]);

        // Kembalikan stok barang BMN ke master
        $barang = Barang::find($loan->barang_id);
        if ($barang) {
            $barang->increment('stok', $loan->jumlah);
        }

        return back()->with('success', 'Pengembalian barang dikonfirmasi dan BAST dirilis!');
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

        if ($bisa) {
            $request->validate([
                'biaya_estimasi' => 'required|numeric|min:0',
                'tanggal_estimasi_selesai' => 'required|date',
            ]);

            $p->update([
                'bisa_diperbaiki' => true,
                'biaya_estimasi' => $request->biaya_estimasi,
                'tanggal_estimasi_selesai' => $request->tanggal_estimasi_selesai,
                'status' => 'proses',
            ]);
        } else {
            $p->update([
                'bisa_diperbaiki' => false,
                'status' => 'rusak_final',
            ]);

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
        $request->validate([
            'pemohon' => 'required|string',
            'buku_ids' => 'required|array|min:1',
            'metode' => 'required|in:ambil,kirim',
            'tanggal_estimasi' => 'required|date',
            'alamat' => 'nullable|string',
            'npsn' => 'nullable|string',
            'satuan_pendidikan' => 'nullable|string',
        ]);

        foreach ($request->buku_ids as $bukuId) {
            PengajuanBuku::create([
                'pemohon' => $request->pemohon,
                'npsn' => $request->npsn,
                'satuan_pendidikan' => $request->satuan_pendidikan,
                'buku_id' => $bukuId,
                'jumlah' => 2,
                'metode' => $request->metode,
                'tanggal_estimasi' => $request->tanggal_estimasi,
                'alamat' => $request->metode === 'kirim' ? $request->alamat : null,
                'status' => 'diproses',
            ]);
        }

        return back()->with('success', 'Pengajuan buku berhasil dikirimkan!');
    }

    public function prosesPengajuanBuku($id)
    {
        $pb = PengajuanBuku::findOrFail($id);
        $statusBaru = ($pb->metode === 'kirim') ? 'siap_kirim' : 'siap_ambil';

        $pb->update(['status' => $statusBaru]);

        return back()->with('success', 'Status pengajuan buku diperbarui menjadi ' . str_replace('_', ' ', $statusBaru));
    }

    public function selesaikanPengajuanBuku(Request $request, $id)
    {
        $request->validate([
            'foto_resi' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $pb = PengajuanBuku::findOrFail($id);

        if ($request->hasFile('foto_resi')) {
            $path = $request->file('foto_resi')->store('resi_buku', 'public');
            $pb->foto_resi = $path;
        }

        $pb->status = 'selesai';
        $pb->save();

        // Kurangi stok buku pada master data
        $buku = Buku::find($pb->buku_id);
        if ($buku && $buku->stok >= $pb->jumlah) {
            $buku->decrement('stok', $pb->jumlah);
        }

        return back()->with('success', 'Pengajuan buku diselesaikan dan bukti telah diunggah!');
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

    // --- LAPORAN 6 BULANAN LOGIC ---
    public function simpanLaporan6Bulan(Request $request)
    {
        $request->validate([
            'peminjaman_id' => 'required|exists:peminjamans,id',
            'kondisi' => 'required|string',
        ]);

        $peminjaman = Peminjaman::findOrFail($request->peminjaman_id);

        LaporanEnamBulan::create([
            'peminjaman_id' => $peminjaman->id,
            'pegawai' => $peminjaman->pegawai,
            'kondisi' => $request->kondisi,
            'periode' => 'Semester ' . (date('n') <= 6 ? '1' : '2') . ' ' . date('Y'),
            'catatan' => $request->catatan ?? 'Laporan periodik 6 bulanan peminjam',
        ]);

        return back()->with('success', 'Laporan periodik 6 bulanan berhasil dikirim!');
    }

    // --- METHOD HAPUS ---
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