<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model
{
    use HasFactory;

    // Tentukan tabel yang digunakan
    protected $table = 'Transaksi';

    // Tentukan primary key
    protected $primaryKey = 'id_transaksi';

    // Tentukan kolom yang dapat diisi (fillable)
    protected $fillable = [
        'id_barang',
        'tgl_transaksi',
        'user_id',
        'satuan',
        'jml_barang',
        'tipe'
    ];

    // Definisikan relasi ke model Barang
    public function barang()
    {
        return $this->belongsTo(Barang::class, 'id_barang', 'id_barang');
    }

    // Definisikan relasi ke model User
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
