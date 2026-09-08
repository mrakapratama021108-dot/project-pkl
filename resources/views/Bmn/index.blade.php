<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>E-BMN Dit PAUD - Sistem Inventaris</title>

    <!-- ==========================================
         STYLESHEETS & FONTS
    =========================================== -->
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; }
    </style>
</head>
<body class="bg-slate-50 text-slate-800 min-h-screen flex antialiased">

    <!-- ==========================================
         SIDEBAR UTAMA
    =========================================== -->
    <aside class="w-64 bg-slate-900 text-slate-300 flex flex-col shrink-0 shadow-xl">
        
        <!-- Sidebar Brand / Logo -->
        <div class="p-5 border-b border-slate-800 flex items-center gap-3">
            <div class="bg-blue-600 p-2 rounded-lg text-white">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>
            </div>
            <div>
                <div class="font-bold text-white text-base tracking-wide">E-BMN PAUD</div>
                <div class="text-xs text-slate-400">Sistem Manajemen BMN</div>
            </div>
        </div>
        
        <!-- Sidebar Navigasi Tab -->
        <nav class="flex-1 p-3 space-y-1">
            @php
                $tabs = [
                    'master' => ['label' => 'Master Data', 'icon' => 'M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z'],
                    'peminjaman' => ['label' => 'Peminjaman', 'icon' => 'M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4'],
                    'pengembalian' => ['label' => 'Pengembalian', 'icon' => 'M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15'],
                    'perbaikan' => ['label' => 'Perbaikan', 'icon' => 'M11 4a2 2 0 114 0v1a2 2 0 01-2 2h-1v1a1 1 0 01-1 1h-2a1 1 0 01-1-1v-1H7a2 2 0 01-2-2V4a2 2 0 114 0v1h2V4z'],
                    'buku' => ['label' => 'Pengajuan Buku', 'icon' => 'M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253'],
                    'laporan' => ['label' => 'Laporan Kehilangan', 'icon' => 'M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z'],
                ];
            @endphp
            @foreach($tabs as $key => $item)
                <a href="?tab={{ $key }}" 
                   class="flex items-center gap-3 px-3.5 py-2.5 rounded-lg text-sm font-medium transition-all {{ $tab === $key ? 'bg-blue-600 text-white shadow-md shadow-blue-600/30' : 'text-slate-400 hover:bg-slate-800 hover:text-slate-200' }}">
                    <svg class="w-5 h-5 opacity-80" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="{{ $item['icon'] }}"></path></svg>
                    {{ $item['label'] }}
                </a>
            @endforeach
        </nav>

        <!-- Profile User & Tombol Logout -->
        <div class="p-4 border-t border-slate-800">
            <div class="bg-slate-800/80 p-3 rounded-xl border border-slate-700/50 flex items-center justify-between">
                <div>
                    <div class="text-xs font-bold text-white">{{ Auth::user()->name }}</div>
                    <div class="text-[10px] text-blue-400 font-semibold mt-0.5">{{ Auth::user()->role }}</div>
                </div>
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button title="Keluar" class="bg-rose-500/10 hover:bg-rose-500/20 text-rose-400 p-1.5 rounded-lg border border-rose-500/30 transition-all">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                    </button>
                </form>
            </div>
        </div>
    </aside>

    <!-- ==========================================
         AREA KONTEN UTAMA
    =========================================== -->
    <main class="flex-1 p-8 overflow-auto">

        <!-- Header Halaman -->
        <header class="flex justify-between items-center mb-8 pb-4 border-b border-slate-200/80">
            <div>
                <h1 class="text-2xl font-bold text-slate-900 capitalize">{{ str_replace('_', ' ', $tab) }}</h1>
                <p class="text-sm text-slate-500 mt-0.5">Kelola seluruh transaksi operasional inventaris BMN dengan cepat dan transparan.</p>
            </div>
            <div class="flex items-center gap-3">
                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold bg-blue-50 text-blue-700 border border-blue-200">
                    <span class="w-2 h-2 rounded-full bg-blue-600 animate-pulse"></span>
                    Role Active: {{ $role }}
                </span>
            </div>
        </header>

        <!-- Notifikasi Sukses / Pesan Flash -->
        @if(session('success'))
            <div class="mb-6 bg-emerald-50 border border-emerald-200 text-emerald-800 px-4 py-3 rounded-xl text-sm flex items-center gap-2 shadow-sm">
                <svg class="w-5 h-5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                <span>{{ session('success') }}</span>
            </div>
        @endif

        <!-- ==========================================
             [SECTION 1] TAB: MASTER DATA
        =========================================== -->
        @if($tab === 'master')
        <div class="space-y-6 max-w-6xl">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                
                <!-- Card Master Barang BMN -->
                <div class="bg-white p-6 border border-slate-200/80 rounded-2xl shadow-sm">
                    <div class="flex items-center justify-between mb-4">
                        <h2 class="font-bold text-base text-slate-900">Master Barang BMN</h2>
                        <span class="text-xs bg-slate-100 text-slate-600 px-2.5 py-1 rounded-md font-medium">{{ $masterBarang->count() }} Items</span>
                    </div>

                    <!-- Form Tambah Barang (Khusus Role Reviewer) -->
                    @if($role === 'Reviewer (Tim BMN)')
                    <form action="{{ route('bmn.barang.tambah') }}" method="POST" class="bg-slate-50 p-4 rounded-xl border border-slate-200/60 space-y-3 mb-5">
                        @csrf
                        <div class="grid grid-cols-2 gap-3">
                            <div>
                                <label class="text-[11px] font-semibold text-slate-500 mb-1 block">Kode Barang</label>
                                <input name="kode_barang" placeholder="Kode barang" class="w-full border border-slate-300 rounded-lg p-2 text-xs focus:ring-2 focus:ring-blue-500 focus:outline-none" required>
                            </div>
                            <div>
                                <label class="text-[11px] font-semibold text-slate-500 mb-1 block">Nama Barang</label>
                                <input name="nama" placeholder="Nama barang" class="w-full border border-slate-300 rounded-lg p-2 text-xs focus:ring-2 focus:ring-blue-500 focus:outline-none" required>
                            </div>
                        </div>
                        <div class="grid grid-cols-2 gap-3">
                            <div>
                                <label class="text-[11px] font-semibold text-slate-500 mb-1 block">Merk</label>
                                <input name="merk" placeholder="Merk" class="w-full border border-slate-300 rounded-lg p-2 text-xs focus:ring-2 focus:ring-blue-500 focus:outline-none" required>
                            </div>
                            <div>
                                <label class="text-[11px] font-semibold text-slate-500 mb-1 block">Tipe / Seri</label>
                                <input name="tipe" placeholder="Tipe" class="w-full border border-slate-300 rounded-lg p-2 text-xs focus:ring-2 focus:ring-blue-500 focus:outline-none" required>
                            </div>
                        </div>
                        <div class="flex items-center gap-3 pt-1">
                            <div class="w-28">
                                <label class="text-[11px] font-semibold text-slate-500 mb-1 block">Jumlah Stok</label>
                                <input type="number" name="jumlah" min="1" value="1" class="w-full border border-slate-300 rounded-lg p-2 text-xs focus:ring-2 focus:ring-blue-500 focus:outline-none" required>
                            </div>
                            <button class="mt-4 flex-1 bg-blue-600 hover:bg-blue-700 text-white font-medium text-xs py-2 px-4 rounded-lg shadow-md shadow-blue-600/20 transition-all">
                                + Tambah Barang
                            </button>
                        </div>
                    </form>
                    @endif

                    <!-- Tabel Daftar Master Barang -->
                    <div class="overflow-x-auto">
                        <table class="w-full text-left text-xs">
                            <thead class="bg-slate-50 text-slate-500 uppercase tracking-wider font-semibold border-y border-slate-200">
                                <tr>
                                    <th class="py-2.5 px-2">Kode</th>
                                    <th class="py-2.5 px-2">Barang</th>
                                    <th class="py-2.5 px-2">Merk/Tipe</th>
                                    <th class="py-2.5 px-2 text-right">Stok</th>
                                    @if($role === 'Reviewer (Tim BMN)')
                                    <th class="py-2.5 px-2 text-center">Aksi</th>
                                    @endif
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100">
                                @forelse($masterBarang as $b)
                                <tr class="hover:bg-slate-50/80 transition-colors">
                                    <td class="py-2.5 px-2 font-mono font-medium text-blue-600">{{ $b->kode_barang ?? '-' }}</td>
                                    <td class="py-2.5 px-2 font-semibold text-slate-800">{{ $b->nama_barang }}</td>
                                    <td class="py-2.5 px-2 text-slate-500">{{ $b->merk }} / {{ $b->tipe }}</td>
                                    <td class="py-2.5 px-2 text-right"><span class="bg-slate-100 text-slate-700 px-2 py-0.5 rounded font-bold">{{ $b->stok }}</span></td>
                                    @if($role === 'Reviewer (Tim BMN)')
                                    <td class="py-2.5 px-2 text-center">
                                        <form action="{{ route('bmn.barang.hapus', $b->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus barang ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button class="bg-rose-50 text-rose-600 hover:bg-rose-600 hover:text-white px-2 py-1 rounded-md text-[10px] font-semibold transition-all">
                                                Hapus
                                            </button>
                                        </form>
                                    </td>
                                    @endif
                                </tr>
                                @empty
                                <tr><td colspan="{{ $role === 'Reviewer (Tim BMN)' ? '5' : '4' }}" class="text-center py-4 text-slate-400 italic">Belum ada data barang.</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Card Master Buku PAUDPEDIA -->
                <div class="bg-white p-6 border border-slate-200/80 rounded-2xl shadow-sm">
                    <div class="flex items-center justify-between mb-4">
                        <h2 class="font-bold text-base text-slate-900">Buku PAUDPEDIA</h2>
                        <span class="text-xs bg-slate-100 text-slate-600 px-2.5 py-1 rounded-md font-medium">{{ $masterBuku->count() }} Titles</span>
                    </div>

                    <!-- Form Tambah Buku (Khusus Role Reviewer) -->
                    @if($role === 'Reviewer (Tim BMN)')
                    <form action="{{ route('bmn.buku.tambah') }}" method="POST" class="bg-slate-50 p-4 rounded-xl border border-slate-200/60 space-y-3 mb-5">
                        @csrf
                        <div>
                            <label class="text-[11px] font-semibold text-slate-500 mb-1 block">Judul Buku</label>
                            <input name="judul" placeholder="Judul buku" class="w-full border border-slate-300 rounded-lg p-2 text-xs focus:ring-2 focus:ring-blue-500 focus:outline-none" required>
                        </div>
                        <div class="flex items-center gap-3">
                            <div class="w-28">
                                <label class="text-[11px] font-semibold text-slate-500 mb-1 block">Stok Buku</label>
                                <input type="number" name="jumlah" min="1" value="1" class="w-full border border-slate-300 rounded-lg p-2 text-xs focus:ring-2 focus:ring-blue-500 focus:outline-none" required>
                            </div>
                            <button class="mt-4 flex-1 bg-blue-600 hover:bg-blue-700 text-white font-medium text-xs py-2 px-4 rounded-lg shadow-md shadow-blue-600/20 transition-all">
                                + Tambah Buku
                            </button>
                        </div>
                    </form>
                    @endif

                    <!-- Tabel Daftar Master Buku -->
                    <div class="overflow-x-auto">
                        <table class="w-full text-left text-xs">
                            <thead class="bg-slate-50 text-slate-500 uppercase tracking-wider font-semibold border-y border-slate-200">
                                <tr>
                                    <th class="py-2.5 px-2">Judul Buku</th>
                                    <th class="py-2.5 px-2 text-right">Stok</th>
                                    @if($role === 'Reviewer (Tim BMN)')
                                    <th class="py-2.5 px-2 text-center">Aksi</th>
                                    @endif
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100">
                                @forelse($masterBuku as $bk)
                                <tr class="hover:bg-slate-50/80 transition-colors">
                                    <td class="py-2.5 px-2 font-medium text-slate-800">{{ $bk->judul }}</td>
                                    <td class="py-2.5 px-2 text-right"><span class="bg-slate-100 text-slate-700 px-2 py-0.5 rounded font-bold">{{ $bk->stok }}</span></td>
                                    @if($role === 'Reviewer (Tim BMN)')
                                    <td class="py-2.5 px-2 text-center">
                                        <form action="{{ route('bmn.buku.hapus', $bk->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus buku ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button class="bg-rose-50 text-rose-600 hover:bg-rose-600 hover:text-white px-2 py-1 rounded-md text-[10px] font-semibold transition-all">
                                                Hapus
                                            </button>
                                        </form>
                                    </td>
                                    @endif
                                </tr>
                                @empty
                                <tr><td colspan="{{ $role === 'Reviewer (Tim BMN)' ? '3' : '2' }}" class="text-center py-4 text-slate-400 italic">Belum ada data buku.</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>
        </div>
        @endif

        <!-- ==========================================
             [SECTION 2] TAB: PEMINJAMAN
        =========================================== -->
        @if($tab === 'peminjaman')
        <div class="space-y-6 max-w-5xl">
            
            <!-- Form Pengajuan Peminjaman (Khusus Role Pegawai) -->
            @if($role === 'Pegawai')
            <div class="bg-white p-6 border border-slate-200/80 rounded-2xl shadow-sm">
                <h2 class="font-bold text-base text-slate-900 mb-4">Form Pengajuan Peminjaman BMN</h2>
                <form action="{{ route('bmn.peminjaman.ajukan') }}" method="POST" class="grid grid-cols-1 md:grid-cols-4 gap-3">
                    @csrf
                    <div>
                        <label class="text-[11px] font-semibold text-slate-500 mb-1 block">Nama Pemohon</label>
                        <input name="pegawai" value="{{ Auth::user()->name }}" readonly class="w-full border border-slate-300 bg-slate-100 rounded-lg p-2 text-xs focus:outline-none" required>
                    </div>
                    <div>
                        <label class="text-[11px] font-semibold text-slate-500 mb-1 block">Pilih Barang BMN</label>
                        <select name="barang_id" class="w-full border border-slate-300 rounded-lg p-2 text-xs focus:ring-2 focus:ring-blue-500 focus:outline-none" required>
                            @foreach($masterBarang as $b)
                                <option value="{{ $b->id }}">{{ $b->nama_barang }} ({{ $b->merk }}) - Stok: {{ $b->stok }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="text-[11px] font-semibold text-slate-500 mb-1 block">Jumlah Pinjam</label>
                        <input type="number" name="jumlah" value="1" min="1" class="w-full border border-slate-300 rounded-lg p-2 text-xs focus:ring-2 focus:ring-blue-500 focus:outline-none" required>
                    </div>
                    <div class="flex items-end">
                        <button class="w-full bg-blue-600 hover:bg-blue-700 text-white font-medium text-xs py-2.5 px-4 rounded-lg shadow-md shadow-blue-600/20 transition-all">
                            Kirim Pengajuan
                        </button>
                    </div>
                </form>
            </div>
            @endif

            <!-- List Transaksi Peminjaman -->
            <div class="bg-white p-6 border border-slate-200/80 rounded-2xl shadow-sm">
                <h2 class="font-bold text-base text-slate-900 mb-4">Daftar Transaksi Peminjaman</h2>
                <div class="space-y-3">
                    @forelse($peminjaman as $l)
                    <div class="flex items-center justify-between p-4 rounded-xl border border-slate-100 bg-slate-50/50 hover:bg-white hover:border-slate-200 hover:shadow-sm transition-all">
                        <div>
                            <div class="text-sm font-semibold text-slate-900">{{ $l->pegawai }}</div>
                            <div class="text-xs text-slate-500 mt-0.5">Meminjam <span class="font-medium text-slate-700">{{ $l->jumlah }}x {{ $l->barang->nama_barang ?? 'Barang' }}</span></div>
                            @if($l->catatan)<div class="text-xs text-amber-600 font-medium mt-1">Catatan: {{ $l->catatan }}</div>@endif
                        </div>
                        <div class="flex items-center gap-3">
                            <span class="px-2.5 py-1 text-[10px] font-bold uppercase tracking-wider rounded-md bg-slate-200 text-slate-700">
                                {{ str_replace('_', ' ', $l->status) }}
                            </span>

                            <!-- Aksi Reviewer (Proses Review) -->
                            @if($role === 'Reviewer (Tim BMN)' && $l->status === 'menunggu_review')
                                <form action="{{ route('bmn.peminjaman.review', $l->id) }}" method="POST">
                                    @csrf @method('PATCH')
                                    <button class="bg-slate-900 hover:bg-slate-800 text-white px-3 py-1.5 rounded-lg text-xs font-medium transition-all">Proses Review</button>
                                </form>
                            @endif

                            <!-- Aksi Approver (Setujui / Tolak) -->
                            @if($role === 'Approver (Kasubag TU)' && $l->status === 'menunggu_approval')
                                <form action="{{ route('bmn.peminjaman.approve', $l->id) }}" method="POST" class="flex gap-1.5">
                                    @csrf @method('PATCH')
                                    <button name="disetujui" value="1" class="bg-emerald-600 hover:bg-emerald-700 text-white px-3 py-1.5 rounded-lg text-xs font-medium transition-all">Setujui</button>
                                    <button name="disetujui" value="0" class="bg-rose-600 hover:bg-rose-700 text-white px-3 py-1.5 rounded-lg text-xs font-medium transition-all">Tolak</button>
                                </form>
                            @endif
                        </div>
                    </div>
                    @empty
                    <p class="text-center py-6 text-xs text-slate-400 italic">Belum ada pengajuan peminjaman.</p>
                    @endforelse
                </div>
            </div>
        </div>
        @endif

        <!-- ==========================================
             [SECTION 3] TAB: PENGEMBALIAN
        =========================================== -->
        @if($tab === 'pengembalian')
        <div class="space-y-6 max-w-5xl">
            <div class="bg-white p-6 border border-slate-200/80 rounded-2xl shadow-sm">
                <h2 class="font-bold text-base text-slate-900 mb-4">Daftar Pengembalian Barang</h2>
                <div class="space-y-3">
                    @forelse($peminjaman->whereIn('status', ['dipinjam', 'menunggu_rilis_pengembalian']) as $l)
                    <div class="flex items-center justify-between p-4 rounded-xl border border-slate-100 bg-slate-50/50 hover:bg-white hover:border-slate-200 hover:shadow-sm transition-all">
                        <div>
                            <div class="text-sm font-semibold text-slate-900">{{ $l->pegawai }}</div>
                            <div class="text-xs text-slate-500 mt-0.5">Barang: <span class="font-medium text-slate-700">{{ $l->jumlah }}x {{ $l->barang->nama_barang }}</span></div>
                        </div>
                        <div class="flex items-center gap-3">
                            <span class="px-2.5 py-1 text-[10px] font-bold uppercase tracking-wider rounded-md bg-blue-50 text-blue-700 border border-blue-200">
                                {{ str_replace('_', ' ', $l->status) }}
                            </span>

                            <!-- Aksi Pegawai (Ajukan Pengembalian) -->
                            @if($role === 'Pegawai' && $l->status === 'dipinjam')
                                <form action="{{ route('bmn.pengembalian.ajukan', $l->id) }}" method="POST">
                                    @csrf @method('PATCH')
                                    <button class="bg-slate-900 text-white px-3 py-1.5 rounded-lg text-xs font-medium transition-all">Ajukan Pengembalian</button>
                                </form>
                            @endif

                            <!-- Aksi Reviewer (Rilis Pengembalian / Terbit BAST) -->
                            @if($role === 'Reviewer (Tim BMN)' && $l->status === 'menunggu_rilis_pengembalian')
                                <form action="{{ route('bmn.pengembalian.rilis', $l->id) }}" method="POST">
                                    @csrf @method('PATCH')
                                    <button class="bg-emerald-600 hover:bg-emerald-700 text-white px-3 py-1.5 rounded-lg text-xs font-medium transition-all">Rilis & Terbit BAST</button>
                                </form>
                            @endif
                        </div>
                    </div>
                    @empty
                    <p class="text-center py-6 text-xs text-slate-400 italic">Tidak ada barang yang sedang dipinjam.</p>
                    @endforelse
                </div>
            </div>
        </div>
        @endif

        <!-- ==========================================
             [SECTION 4] TAB: PERBAIKAN
        =========================================== -->
        @if($tab === 'perbaikan')
        <div class="space-y-6 max-w-5xl">
            
            <!-- Form Lapor Rusak / Perbaikan (Khusus Role Pegawai) -->
            @if($role === 'Pegawai')
            <div class="bg-white p-6 border border-slate-200/80 rounded-2xl shadow-sm">
                <h2 class="font-bold text-base text-slate-900 mb-4">Laporkan Barang Rusak / Perbaikan</h2>
                <form action="{{ route('bmn.perbaikan.ajukan') }}" method="POST" class="flex gap-3">
                    @csrf
                    <div class="w-1/3">
                        <select name="barang_id" class="w-full border border-slate-300 rounded-lg p-2 text-xs focus:ring-2 focus:ring-blue-500 focus:outline-none">
                            @foreach($masterBarang as $b)
                                <option value="{{ $b->id }}">{{ $b->nama_barang }} ({{ $b->merk }})</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="flex-1">
                        <input name="keluhan" placeholder="Deskripsi keluhan / kerusakan barang..." class="w-full border border-slate-300 rounded-lg p-2 text-xs focus:ring-2 focus:ring-blue-500 focus:outline-none" required>
                    </div>
                    <button class="bg-blue-600 hover:bg-blue-700 text-white font-medium text-xs px-4 py-2 rounded-lg transition-all">
                        Ajukan Perbaikan
                    </button>
                </form>
            </div>
            @endif

            <!-- List Pengajuan Perbaikan -->
            <div class="bg-white p-6 border border-slate-200/80 rounded-2xl shadow-sm">
                <h2 class="font-bold text-base text-slate-900 mb-4">Daftar Pengajuan Perbaikan</h2>
                <div class="space-y-3">
                    @forelse($perbaikan as $p)
                    <div class="flex items-center justify-between p-4 rounded-xl border border-slate-100 bg-slate-50/50 hover:bg-white hover:border-slate-200 transition-all">
                        <div>
                            <div class="text-sm font-semibold text-slate-900">{{ $p->barang->nama_barang }}</div>
                            <div class="text-xs text-slate-500 mt-0.5">Keluhan: {{ $p->keluhan }}</div>
                        </div>
                        <div class="flex items-center gap-3">
                            <span class="px-2.5 py-1 text-[10px] font-bold uppercase tracking-wider rounded-md bg-slate-200 text-slate-700">
                                {{ str_replace('_', ' ', $p->status) }}
                            </span>

                            <!-- Aksi Keputusan Reviewer -->
                            @if($role === 'Reviewer (Tim BMN)' && $p->status === 'menunggu_reviewer')
                                <form action="{{ route('bmn.perbaikan.putuskan', $p->id) }}" method="POST" class="flex gap-1.5">
                                    @csrf @method('PATCH')
                                    <button name="bisa_diperbaiki" value="1" class="bg-blue-600 text-white px-3 py-1.5 rounded-lg text-xs font-medium">Bisa Diperbaiki</button>
                                    <button name="bisa_diperbaiki" value="0" class="bg-rose-600 text-white px-3 py-1.5 rounded-lg text-xs font-medium">Rusak Final</button>
                                </form>
                            @endif

                            <!-- Aksi Tandai Selesai Reviewer -->
                            @if($role === 'Reviewer (Tim BMN)' && $p->status === 'proses')
                                <form action="{{ route('bmn.perbaikan.selesai', $p->id) }}" method="POST">
                                    @csrf @method('PATCH')
                                    <button class="bg-emerald-600 text-white px-3 py-1.5 rounded-lg text-xs font-medium">Tandai Selesai</button>
                                </form>
                            @endif
                        </div>
                    </div>
                    @empty
                    <p class="text-center py-6 text-xs text-slate-400 italic">Belum ada pengajuan perbaikan.</p>
                    @endforelse
                </div>
            </div>
        </div>
        @endif

        <!-- ==========================================
             [SECTION 5] TAB: PENGAJUAN BUKU
        =========================================== -->
        @if($tab === 'buku')
        <div class="space-y-6 max-w-5xl">
            
            <!-- Form Pengajuan Buku PAUDPEDIA (Khusus Role Pegawai) -->
            @if($role === 'Pegawai')
            <div class="bg-white p-6 border border-slate-200/80 rounded-2xl shadow-sm">
                <h2 class="font-bold text-base text-slate-900 mb-4">Form Pengajuan Buku PAUDPEDIA</h2>
                <form action="{{ route('bmn.buku.ajukan') }}" method="POST" class="space-y-4">
                    @csrf
                    <div class="grid grid-cols-1 md:grid-cols-4 gap-3">
                        <div>
                            <label class="text-[11px] font-semibold text-slate-500 mb-1 block">Nama Pemohon</label>
                            <input name="pemohon" value="{{ Auth::user()->name }}" readonly class="w-full border border-slate-300 bg-slate-100 rounded-lg p-2 text-xs focus:outline-none" required>
                        </div>
                        <div>
                            <label class="text-[11px] font-semibold text-slate-500 mb-1 block">Judul Buku</label>
                            <select name="buku_id" class="w-full border border-slate-300 rounded-lg p-2 text-xs focus:ring-2 focus:ring-blue-500 focus:outline-none" required>
                                @foreach($masterBuku->where('stok', '>', 0) as $bk)
                                    <option value="{{ $bk->id }}">{{ $bk->judul }} (Stok: {{ $bk->stok }})</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="text-[11px] font-semibold text-slate-500 mb-1 block">Jumlah Eksemplar</label>
                            <input type="number" name="jumlah" value="1" min="1" class="w-full border border-slate-300 rounded-lg p-2 text-xs focus:ring-2 focus:ring-blue-500 focus:outline-none" required>
                        </div>
                        <div>
                            <label class="text-[11px] font-semibold text-slate-500 mb-1 block">Metode Pengambilan</label>
                            <select name="metode" id="metodeBuku" onchange="toggleAlamatInput()" class="w-full border border-slate-300 rounded-lg p-2 text-xs focus:ring-2 focus:ring-blue-500 focus:outline-none">
                                <option value="ambil">Ambil di Kantor</option>
                                <option value="kirim">Dikirim (COD)</option>
                            </select>
                        </div>
                    </div>

                    <!-- Input Alamat Kirim (Dynamic Toggle JS) -->
                    <div id="alamatContainer" class="hidden">
                        <label class="text-[11px] font-semibold text-slate-500 mb-1 block">Alamat Pengiriman (Khusus COD)</label>
                        <textarea name="alamat" id="inputAlamat" rows="2" placeholder="Masukkan alamat lengkap tujuan pengiriman..." class="w-full border border-slate-300 rounded-lg p-2 text-xs focus:ring-2 focus:ring-blue-500 focus:outline-none"></textarea>
                    </div>

                    <div class="flex justify-end">
                        <button class="bg-blue-600 hover:bg-blue-700 text-white font-medium text-xs py-2.5 px-6 rounded-lg shadow-md shadow-blue-600/20 transition-all">
                            Ajukan Buku
                        </button>
                    </div>
                </form>

                <script>
                    function toggleAlamatInput() {
                        const metode = document.getElementById('metodeBuku').value;
                        const container = document.getElementById('alamatContainer');
                        const input = document.getElementById('inputAlamat');
                        if (metode === 'kirim') {
                            container.classList.remove('hidden');
                            input.setAttribute('required', 'required');
                        } else {
                            container.classList.add('hidden');
                            input.removeAttribute('required');
                        }
                    }
                </script>
            </div>
            @endif

            <!-- List Transaksi Pengajuan Buku -->
            <div class="bg-white p-6 border border-slate-200/80 rounded-2xl shadow-sm">
                <h2 class="font-bold text-base text-slate-900 mb-4">Daftar Pengajuan Buku</h2>
                <div class="space-y-3">
                    @forelse($pengajuanBuku as $pb)
                    <div class="flex items-center justify-between p-4 rounded-xl border border-slate-100 bg-slate-50/50 hover:bg-white hover:border-slate-200 transition-all">
                        <div>
                            <div class="text-sm font-semibold text-slate-900">{{ $pb->pemohon ?? 'Pegawai' }}</div>
                            <div class="text-xs text-slate-600 font-medium mt-0.5">Buku: {{ $pb->buku->judul ?? '-' }} ({{ $pb->jumlah }} Eksemplar)</div>
                            <div class="text-xs text-slate-500 mt-0.5">Metode: <span class="uppercase font-semibold text-blue-600">{{ $pb->metode }}</span></div>
                            
                            <!-- Alamat Pengiriman -->
                            @if($pb->metode === 'kirim' && $pb->alamat)
                                <div class="text-xs text-slate-500 bg-slate-100 p-2 rounded-md mt-1.5 border border-slate-200/60">
                                    <strong>Alamat Kirim:</strong> {{ $pb->alamat }}
                                </div>
                            @endif

                            <!-- Display Bukti Resi / Foto BAST -->
                            @if($pb->foto_resi)
                                <div class="mt-2.5">
                                    <span class="text-[10px] font-bold text-slate-500 block mb-1">Bukti Resi / BAST:</span>
                                    <a href="{{ asset('storage/' . $pb->foto_resi) }}" target="_blank">
                                        <img src="{{ asset('storage/' . $pb->foto_resi) }}" class="w-32 h-20 object-cover rounded-lg border border-slate-200 hover:opacity-90 transition-all shadow-sm">
                                    </a>
                                </div>
                            @endif
                        </div>
                        <div class="flex items-center gap-3">
                            <span class="px-2.5 py-1 text-[10px] font-bold uppercase tracking-wider rounded-md bg-slate-200 text-slate-700">
                                {{ str_replace('_', ' ', $pb->status) }}
                            </span>

                            <!-- Aksi Reviewer: Proses Pengajuan -->
                            @if($role === 'Reviewer (Tim BMN)' && $pb->status === 'diproses')
                                <form action="{{ route('bmn.buku.proses', $pb->id) }}" method="POST">
                                    @csrf @method('PATCH')
                                    <button class="bg-slate-900 text-white px-3 py-1.5 rounded-lg text-xs font-medium">Proses Pengajuan</button>
                                </form>
                            @endif

                            <!-- Aksi Reviewer: Upload Resi & Selesaikan BAST -->
                            @if($role === 'Reviewer (Tim BMN)' && in_array($pb->status, ['siap_ambil', 'siap_kirim']))
                                <form action="{{ route('bmn.buku.selesai', $pb->id) }}" method="POST" enctype="multipart/form-data" class="flex items-center gap-2">
                                    @csrf @method('PATCH')
                                    <input type="file" name="foto_resi" accept="image/*" class="text-[10px] text-slate-500 file:mr-2 file:py-1 file:px-2 file:rounded-md file:border-0 file:text-[10px] file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100" required>
                                    <button class="bg-emerald-600 hover:bg-emerald-700 text-white px-3 py-1.5 rounded-lg text-xs font-medium transition-all shrink-0">Upload & Selesaikan</button>
                                </form>
                            @endif
                        </div>
                    </div>
                    @empty
                    <p class="text-center py-6 text-xs text-slate-400 italic">Belum ada pengajuan buku.</p>
                    @endforelse
                </div>
            </div>
        </div>
        @endif

        <!-- ==========================================
             [SECTION 6] TAB: LAPORAN KEHILANGAN
        =========================================== -->
        @if($tab === 'laporan')
        <div class="space-y-6 max-w-5xl">
            
            <!-- Form Lapor Kehilangan (Khusus Role Pegawai) -->
            @if($role === 'Pegawai')
            <div class="bg-white p-6 border border-slate-200/80 rounded-2xl shadow-sm">
                <h2 class="font-bold text-base text-slate-900 mb-3">Lapor Barang Pinjaman Hilang</h2>
                <div class="space-y-2">
                    @forelse($peminjaman->where('status', 'dipinjam') as $l)
                    <div class="flex justify-between items-center p-3 rounded-lg border border-slate-200 bg-slate-50">
                        <div class="text-xs text-slate-700"><span class="font-bold">{{ $l->pegawai }}</span> meminjam {{ $l->barang->nama_barang }}</div>
                        <form action="{{ route('bmn.hilang.laporkan', $l->id) }}" method="POST">
                            @csrf
                            <button class="bg-rose-600 hover:bg-rose-700 text-white px-3 py-1.5 rounded-lg text-xs font-medium transition-all">Laporkan Hilang</button>
                        </form>
                    </div>
                    @empty
                    <p class="text-xs text-slate-400 italic">Tidak ada barang pinjaman aktif untuk dilaporkan.</p>
                    @endforelse
                </div>
            </div>
            @endif

            <!-- List Laporan Kehilangan -->
            <div class="bg-white p-6 border border-slate-200/80 rounded-2xl shadow-sm">
                <h2 class="font-bold text-base text-slate-900 mb-4">Daftar Laporan Kehilangan</h2>
                <div class="space-y-3">
                    @forelse($laporanHilang as $lh)
                    <div class="flex justify-between items-center p-4 rounded-xl border border-slate-100 bg-slate-50/50 hover:bg-white hover:border-slate-200 transition-all">
                        <div>
                            <div class="text-sm font-semibold text-slate-900">{{ $lh->peminjaman->pegawai }}</div>
                            <div class="text-xs text-slate-500 mt-0.5">Barang Hilang: <span class="font-medium text-slate-700">{{ $lh->peminjaman->barang->nama_barang }}</span></div>
                        </div>
                        <div class="flex items-center gap-3">
                            <span class="px-2.5 py-1 text-[10px] font-bold uppercase tracking-wider rounded-md bg-rose-100 text-rose-800">
                                {{ str_replace('_', ' ', $lh->status) }}
                            </span>

                            <!-- Aksi Reviewer: ACC Kehilangan -->
                            @if($role === 'Reviewer (Tim BMN)' && $lh->status === 'menunggu_acc')
                                <form action="{{ route('bmn.hilang.acc', $lh->id) }}" method="POST">
                                    @csrf @method('PATCH')
                                    <button class="bg-blue-600 text-white px-3 py-1.5 rounded-lg text-xs font-medium">ACC & Tutup Laporan</button>
                                </form>
                            @endif
                        </div>
                    </div>
                    @empty
                    <p class="text-center py-6 text-xs text-slate-400 italic">Belum ada laporan kehilangan.</p>
                    @endforelse
                </div>
            </div>
        </div>
        @endif

    </main>
</body>
</html>