<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>BAST Peminjaman BMN #{{ $peminjaman->id }}</title>
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
    <div class="header">BERITA ACARA SERAH TERIMA PEMINJAMAN BMN</div>
    <p>Pada hari ini, tanggal <strong>{{ now()->translatedFormat('d F Y') }}</strong>, telah diserahkan Barang Milik Negara (BMN) untuk keperluan operasional kantor:</p>

    <table>
        <tr>
            <th width="35%">Nama Penerima Pinjaman</th>
            <td>{{ $peminjaman->pegawai }}</td>
        </tr>
        <tr>
            <th>Barang BMN</th>
            <td>{{ $peminjaman->barang->nama_barang ?? '-' }} ({{ $peminjaman->barang->merk ?? '' }} {{ $peminjaman->barang->tipe ?? '' }})</td>
        </tr>
        <tr>
            <th>Jumlah Dipinjam</th>
            <td>{{ $peminjaman->jumlah }} Unit</td>
        </tr>
        <tr>
            <th>Status Peminjaman</th>
            <td><strong>{{ strtoupper(str_replace('_', ' ', $peminjaman->status)) }}</strong></td>
        </tr>
    </table>

    <div class="flex-ttd">
        <div class="box-ttd">
            <p>Yang Menyerahkan (Tim BMN),</p>
            <br><br><br><br>
            <p><strong>( Tim BMN Dit PAUD )</strong></p>
        </div>
        <div class="box-ttd">
            <p>Yang Menerima,</p>
            <br><br><br><br>
            <p><strong>({{ $peminjaman->pegawai }})</strong></p>
        </div>
    </div>
</body>
</html>