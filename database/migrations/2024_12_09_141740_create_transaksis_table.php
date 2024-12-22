<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransaksisTable extends Migration
{
    /**
     * Menjalankan migration untuk membuat tabel transaksi.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transaksi', function (Blueprint $table) {
    $table->increments('id_transaksi'); // Primary key
    $table->unsignedBigInteger('user_id'); // Foreign key harus cocok deangan tipe primary key di tabel users
    $table->unsignedInteger('id_barang'); // Foreign key ke tabel barangs
    $table->date('tgl_transaksi')->useCurrent();
    $table->string('satuan', 50);
    $table->integer('jml_barang');
    $table->enum('tipe', ['in', 'out']);
    $table->timestamps();

    // Definisi foreign key
    $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
    $table->foreign('id_barang')->references('id_barang')->on('barang')->onDelete('cascade');
});

    }

    /**
     * Membatalkan migration.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('transaksi');
    }
}
