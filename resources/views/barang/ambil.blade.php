@extends('layouts.app')

@section('content')
    <div class="container mx-auto px-6 py-8">
        <h1 class="text-3xl font-semibold mb-4">Ambil Barang: {{ $barang->nama_Barang }}</h1>

        <form action="{{ route('barang.ambilStok', $barang->id_barang) }}" method="POST" class="space-y-6">
            @csrf
            @method('PUT')
            <input type="text" name="nama_Barang" value="{{ $barang->nama_Barang }}" hidden>
            
            <div class="mb-4">
                <label for="jumlah" class="block text-sm font-medium text-gray-700">Jumlah yang Diambil</label>
                <input type="number" name="jumlah" value="1" min="1" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" required>
            </div>

            <button type="submit" class="w-full py-2 px-4 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition">Ambil Barang</button>
        </form>

        <div class="mt-4">
            <p class="text-gray-700">Stok saat ini: {{ $barang->stok }}</p>
        </div>
    </div>
@endsection
