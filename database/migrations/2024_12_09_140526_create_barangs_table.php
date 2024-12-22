<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;


return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {

        Schema::create('Barang', function (Blueprint $table) {
            $table->increments('id_barang');
            $table->string('nama_Barang');
            $table->string('satuan', 50);
            $table->integer('stok');
            $table->date('tanggal')->default(DB::raw('CURRENT_DATE'));
            $table->date('tgl_kadaluarsa');
            $table->integer('minimum_Stok');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('barangs');
    }
};
