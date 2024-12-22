<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Barang extends Model
{
    use HasFactory;

    protected $table = 'Barang';
    protected $primaryKey = 'id_barang';
    protected $fillable = ['nama_Barang', 'satuan', 'stok', 'tanggal', 'tgl_kadaluarsa', 'minimum_Stok'];

    // Menambahkan casting untuk kolom tanggal
    protected $casts = [
        'tanggal' => 'datetime',
        'tgl_kadaluarsa' => 'datetime',
    ];
}
