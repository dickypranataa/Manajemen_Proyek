@extends('layouts.app')
@section('content')
<div class="container mx-auto px-6 py-8" id="printableContainer">
    <h1 class="text-3xl font-semibold mb-4 w-full text-center">
        Notifikasi
    </h1>


    <!-- Barang Hampir Habis -->
    <h2 class="text-2xl font-semibold mb-3">Barang Hampir Habis</h2>
    @if($barangAlmostOutOfStock->isEmpty())
    <p class="text-gray-600">Tidak ada barang yang hampir habis.</p>
    @else
    <div class="overflow-x-auto bg-white shadow-md rounded-lg">
        <table class="min-w-full table-auto">
            <thead>
                <tr class="bg-blue-500 text-white">
                    <th class="px-4 py-2 text-left text-sm font-medium">Nama Barang</th>
                    <th class="px-4 py-2 text-left text-sm font-medium">Stok</th>
                    <th class="px-4 py-2 text-left text-sm font-medium">Minimum Stok</th>
                </tr>
            </thead>
            <tbody>
                @foreach($barangAlmostOutOfStock as $item)
                <tr class="border-t">
                    <td class="px-4 py-2 text-sm">{{ $item->nama_Barang }}</td>
                    <td class="px-4 py-2 text-sm">{{ $item->stok }}</td>
                    <td class="px-4 py-2 text-sm">{{ $item->minimum_Stok }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @endif

    <!-- Barang Hampir Kadaluarsa -->
    <h2 class="text-2xl font-semibold mt-10 mb-3">Barang Hampir Kadaluarsa</h2>
    @if($barangExpiringSoon->isEmpty())
    <p class="text-gray-600">Tidak ada barang yang hampir kadaluarsa dalam 7 hari ke depan.</p>
    @else
    <div class="overflow-x-auto bg-white shadow-md rounded-lg">
        <table class="min-w-full table-auto">
            <thead>
                <tr class="bg-blue-500 text-white">
                    <th class="px-4 py-2 text-left text-sm font-medium">Nama Barang</th>
                    <th class="px-4 py-2 text-left text-sm font-medium">Tanggal Kadaluarsa</th>
                </tr>
            </thead>
            <tbody>
                @foreach($barangExpiringSoon as $item)
                <tr class="border-t">
                    <td class="px-4 py-2 text-sm text-gray-700">{{ $item->nama_Barang }}</td>
                    <!-- Format tanggal kadaluarsa -->
                    <td class="px-4 py-2 text-sm text-gray-700">{{ \Carbon\Carbon::parse($item->tgl_kadaluarsa)->format('d-m-Y') }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @endif

    <!-- Barang Sudah Kadaluarsa -->
    <h2 class="text-2xl font-semibold mt-10 mb-3">Barang Sudah Kadaluarsa</h2>
    @if($barangExpired->isEmpty())
    <p class="text-gray-600">Tidak ada barang yang sudah kadaluarsa.</p>
    @else
    <div class="overflow-x-auto bg-white shadow-md rounded-lg">
        <table class="min-w-full table-auto">
            <thead>
                <tr class="bg-blue-500 text-white">
                    <th class="px-4 py-2 text-left text-sm font-medium">Nama Barang</th>
                    <th class="px-4 py-2 text-left text-sm font-medium">Tanggal Kadaluarsa</th>
                </tr>
            </thead>
            <tbody>
                @foreach($barangExpired as $item)
                <tr class="border-t">
                    <td class="px-4 py-2 text-sm text-grey-700">{{ $item->nama_Barang }}</td>
                    <!-- Format tanggal kadaluarsa -->
                    <td class="px-4 py-2 text-sm text-grey-700">{{ \Carbon\Carbon::parse($item->tgl_kadaluarsa)->format('d-m-Y') }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @endif
</div>
@endsection