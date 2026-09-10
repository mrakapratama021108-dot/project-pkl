<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>BAST Pengembalian BMN #{{ $peminjaman->id }}</title>
    <style>
        body { font-family: sans-serif; padding: 30px; font-size: 13px; line-height: 1.6; }
        .header { text-align: center; font-weight: bold; font-size: 16px; margin-bottom: 25px; text-transform: uppercase; }
        table { width: 100%; border-collapse: collapse; margin: 20px 0; }
        table, th, td { border: 1px solid #333; padding: 10px; }
        th { bg-color: #f4f4f4; text-align: left; }
        .flex-ttd { margin-top: 60px; display: flex; justify-content: space-between; }
        .box-ttd { text-align: center; width: 40%; }
    </style>
</head>
<body onload="window.print()">
    <div class="header">BERITA ACARA SERAH TERIMA PENGEMBALIAN BMN</div>
    <p>Pada hari ini, tanggal <strong>{{ now()->translatedFormat('d F Y') }}</strong>, kami yang bertanda tangan di bawah ini telah melakukan serah terima pengembalian Barang Milik Negara (BMN):</p>

    <table>
        <tr>
            <th width="35%">Nama Peminjam / Pegawai</th>
            <td>{{ $peminjaman->pegawai }}</td>
        </tr>
        <tr>
            <th>Barang BMN</th>
            <td>{{ $peminjaman->barang->nama_barang ?? '-' }} ({{ $peminjaman->barang->merk ?? '' }} {{ $peminjaman->barang->tipe ?? '' }})</td>
        </tr>
        <tr>
            <th>Jumlah Dikembalikan</th>
            <td>{{ $peminjaman->jumlah }} Unit</td>
        </tr>
        <tr>
            <th>Kondisi Pengembalian</th>
            <td><strong>{{ strtoupper($peminjaman->kondisi_kembali ?? 'BAIK') }}</strong></td>
        </tr>
        <tr>
            <th>Catatan Petugas</th>
            <td>{{ $peminjaman->catatan_kembali ?? '-' }}</td>
        </tr>
    </table>

    <div class="flex-ttd">
        <div class="box-ttd">
            <p>Yang Mengembalikan,</p>
            <br><br><br><br>
            <p><strong>({{ $peminjaman->pegawai }})</strong></p>
        </div>
        <div class="box-ttd">
            <p>Yang Menerima (Tim BMN),</p>
            <br><br><br><br>
            <p><strong>( Tim BMN Dit PAUD )</strong></p>
        </div>
    </div>
</body>
</html>