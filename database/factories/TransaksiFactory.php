<?php

namespace Database\Factories;

use App\Models\Transaksi;
use App\Models\Barang;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class TransaksiFactory extends Factory
{
    protected $model = Transaksi::class;

    public function definition()
    {
        return [
            'id_barang' => Barang::all()->random()->id_barang, // Mengambil barang acak dari tabel Barang
            'tgl_transaksi' => $this->faker->dateTimeThisYear(), // Tanggal transaksi acak pada tahun ini
            'user_id' => User::all()->random()->id, // Mengambil user acak dari tabel User
            'satuan' => $this->faker->randomElement(['kg', 'ltr', 'pcs', 'buah']), // Satuan acak
            'jml_barang' => $this->faker->numberBetween(1, 100), // Jumlah barang acak
            'tipe' => $this->faker->randomElement(['in', 'out']), // Tipe transaksi (masuk atau keluar)
        ];
    }
}
