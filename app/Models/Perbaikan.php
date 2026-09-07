<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Perbaikan extends Model {
    protected $guarded = [];
    public function barang() { return $this->belongsTo(Barang::class); }
}