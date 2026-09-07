<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class LaporanHilang extends Model {
    protected $table = 'laporan_hilangs';
    protected $guarded = [];
    public function peminjaman() { return $this->belongsTo(Peminjaman::class); }
}