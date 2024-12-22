<!-- resources/views/barang/edit.blade.php -->
@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-6">
    <h1 class="text-3xl font-bold text-gray-800 mb-6">Edit Barang</h1>

    <form action="{{ route('barang.update', $barang->id_barang) }}" method="POST" class="bg-white shadow-lg rounded-lg p-6">
        @csrf
        @method('PUT')

        <div class="mb-4">
            <label for="nama_Barang" class="block text-gray-700 font-medium">Nama Barang</label>
            <input type="text" name="nama_Barang" id="nama_Barang" class="w-full px-4 py-2 border rounded-lg" value="{{ $barang->nama_Barang }}" required>
        </div>

        <div class="mb-4">
            <label for="satuan" class="block text-gray-700 font-medium">Satuan</label>
            <input type="text" name="satuan" id="satuan" class="w-full px-4 py-2 border rounded-lg" value="{{ $barang->satuan }}" required>
        </div>

        <div class="mb-4">
            <label for="stok" class="block text-gray-700 font-medium">Stok</label>
            <input type="number" name="stok" id="stok" class="w-full px-4 py-2 border rounded-lg" value="{{ $barang->stok }}" required>
        </div>

        <div class="mb-4">
            <label for="tgl_kadaluarsa" class="block text-gray-700 font-medium">Tanggal Kadaluarsa</label>
            <input type="date" name="tgl_kadaluarsa" id="tgl_kadaluarsa" class="w-full px-4 py-2 border rounded-lg" value="{{ $barang->tgl_kadaluarsa }}" required>
        </div>

        <div class="mb-4">
            <label for="minimum_Stok" class="block text-gray-700 font-medium">Minimum Stok</label>
            <input type="number" name="minimum_Stok" id="minimum_Stok" class="w-full px-4 py-2 border rounded-lg" value="{{ $barang->minimum_Stok }}" required>
        </div>

        <button type="submit" class="w-full bg-blue-600 text-white py-2 px-4 rounded-lg hover:bg-blue-700">
            Update Barang
        </button>
    </form>
</div>
@endsection
