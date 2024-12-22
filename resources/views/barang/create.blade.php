@extends('layouts.app')
<?php $user->id ?>

@section('content')
    <div class="mb-6 border-b border-gray-200">
        <ul class="flex flex-wrap -mb-px text-sm font-medium text-center">
            <li class="mr-2">
                <a href="{{ route('barang.create') }}" 
                class="inline-block p-4 border-b-2 rounded-t-lg {{ request()->is('barang/create') ? 'border-blue-600 text-blue-600' : 'border-transparent text-gray-500 hover:text-gray-600' }}">
                    Tambah Barang
                </a>
            </li>
            <li class="mr-2">
                <a href="{{ route('barang.show') }}" 
                class="inline-block p-4 border-b-2 rounded-t-lg {{ request()->is('barang/showStokForm') ? 'border-blue-600 text-blue-600' : 'border-transparent text-gray-500 hover:text-gray-600' }}">
                    Tambah Stok
                </a>
            </li>
        </ul>
    </div>

    <div class="container mx-auto px-6 py-8">
        <h1 class="text-3xl font-semibold mb-4">Tambah Barang</h1>

        <!-- Form tambah barang -->
        <form action="{{ route('barang.store') }}" method="POST" class="space-y-6">
            @csrf

            <!-- input id user -->
            <input type="text" name="nama_Barang" value="{{ $user->id }}" hidden required>

            <!-- Nama Barang -->
            <div class="mb-2">
                <label for="nama_Barang" class="block text-sm font-medium text-gray-700">Nama Barang</label>
                <input type="text" name="nama_Barang" value="{{ old('nama_Barang') }}" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" required>
                @error('nama_Barang')
                    <span class="text-red-500 text-xs">{{ $message }}</span>
                @enderror
            </div>

            <!-- Satuan -->
            <div class="mb-2">
                <label for="satuan" class="block text-sm font-medium text-gray-700">Satuan</label>
                <input type="text" name="satuan" value="{{ old('satuan') }}" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" required>
                @error('satuan')
                    <span class="text-red-500 text-xs">{{ $message }}</span>
                @enderror
            </div>

            <!-- Stok -->
            <div class="mb-2">
                <label for="stok" class="block text-sm font-medium text-gray-700">Stok</label>
                <input type="number" name="stok" value="{{ old('stok') }}" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" required>
                @error('stok')
                    <span class="text-red-500 text-xs">{{ $message }}</span>
                @enderror
            </div>

            <!-- Tanggal Kadaluarsa -->
            <div class="mb-2">
                <label for="tgl_kadaluarsa" class="block text-sm font-medium text-gray-700">Tanggal Kadaluarsa</label>
                <input type="date" name="tgl_kadaluarsa" value="{{ old('tgl_kadaluarsa') }}" class="mt-1 block px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" required>
                @error('tgl_kadaluarsa')
                    <span class="text-red-500 text-xs">{{ $message }}</span>
                @enderror
            </div>

            <!-- Minimum Stok -->
            <div class="mb-2">
                <label for="minimum_Stok" class="block text-sm font-medium text-gray-700">Minimum Stok</label>
                <input type="number" name="minimum_Stok" min= 1 value="{{ old('minimum_Stok') }}" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" required>
                @error('minimum_Stok')
                    <span class="text-red-500 text-xs">{{ $message }}</span>
                @enderror
            </div>

            <!-- Button Simpan -->
            <button type="submit" class="w-full py-2 px-4 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition">Simpan</button>
        </form>
    </div>
@endsection
