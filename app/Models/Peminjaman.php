<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Peminjaman extends Model {
    protected $table = 'peminjamans';
    protected $guarded = [];
    
    public function barang() { 
        return $this->belongsTo(Barang::class); 
    }
}