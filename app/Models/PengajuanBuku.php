<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class PengajuanBuku extends Model {
    protected $table = 'pengajuan_bukus';
    protected $guarded = [];
    public function buku() { return $this->belongsTo(Buku::class); }
}