<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory;

    // Menentukan kolom yang dapat diisi menggunakan metode mass assignment
    protected $fillable = [
        'name',
        'password',
        'role',
        'tgl_buat',
    ];

    public function transaksi()
    {
        return $this->hasMany(Transaksi::class, 'user_id', 'id');
    }
}
