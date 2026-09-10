<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Rekap Laporan 6 Bulanan BMN - {{ $periode }}</title>
    <style>
        body { font-family: sans-serif; padding: 10px; font-size: 10pt; line-height: 1.4; }
        .header { text-align: center; margin-bottom: 25px; }
        .header h2 { margin: 0; font-size: 13pt; text-transform: uppercase; }
        .header p { margin: 3px 0 0 0; font-size: 9pt; color: #444; }
        table { width: 100%; border-collapse: collapse; margin-top: 15px; }
        table, th, td { border: 1px solid #333; }
        th { background-color: #f2f2f2; padding: 7px; text-align: center; font-size: 9pt; }
        td { padding: 7px; font-size: 9pt; }
        .text-center { text-align: center; }
        .ttd-container { margin-top: 50px; width: 100%; }
        .ttd-box { float: left; width: 48%; text-align: center; }
        .clear { clear: both; }
    </style>
</head>
<body>

    <div class="header">
        <h2>REKAPITULASI PELAPORAN PERIODIK 6 BULANAN BMN</h2>
        <p>DIREKTORAT PAUD - PERIODE {{ strtoupper($periode) }}</p>
    </div>

    <table>
        <thead>
            <tr>
                <th width="5%">No</th>
                <th width="25%">Nama Peminjam</th>
                <th width="35%">Barang BMN (Merk/Tipe)</th>
                <th width="15%">Periode</th>
                <th width="20%">Kondisi Fisik</th>
            </tr>
        </thead>
        <tbody>
            @forelse($laporan as $index => $item)
            <tr>
                <td class="text-center">{{ $index + 1 }}</td>
                <td>{{ $item->pegawai }}</td>
                <td>{{ $item->peminjaman->barang->nama_barang ?? '-' }} ({{ $item->peminjaman->barang->merk ?? '' }})</td>
                <td class="text-center">{{ $item->periode }}</td>
                <td class="text-center"><strong>{{ strtoupper($item->kondisi) }}</strong></td>
            </tr>
            @empty
            <tr>
                <td colspan="5" class="text-center">Belum ada data pelaporan periodik untuk periode ini.</td>
            </tr>
            @endforelse
        </tbody>
    </table>

    <div class="ttd-container">
        <div class="ttd-box">
            <p>Mengetahui,<br><strong>Kasubag TU</strong></p>
            <br><br><br><br>
            <p><strong>( ______________________ )</strong></p>
        </div>
        <div class="ttd-box">
            <p>Jakarta, {{ now()->translatedFormat('d F Y') }}<br><strong>Tim Pengelola BMN</strong></p>
            <br><br><br><br>
            <p><strong>( ______________________ )</strong></p>
        </div>
        <div class="clear"></div>
    </div>

</body>
</html>