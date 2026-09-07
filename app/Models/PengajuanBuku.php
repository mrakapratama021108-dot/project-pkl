<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PengajuanBuku extends Model
{
    protected $table = 'pengajuan_bukus';
    protected $guarded = []; // Mengizinkan semua kolom diisi

    public function buku()
    {
        return $this->belongsTo(Buku::class);
    }
}