<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LaporanEnamBulan extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function peminjaman()
    {
        return $table = $this->belongsTo(Peminjaman::class, 'peminjaman_id');
    }
}