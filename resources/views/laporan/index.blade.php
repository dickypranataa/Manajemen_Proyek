@extends('layouts.app')

@section('content')
<div class="container mx-auto px-6 py-8 " id="printableTable">
    <h1 class="text-3xl font-semibold mb-6 text-center text-gray-800">Laporan dan Analitik Transaksi</h1>

    @if (session('success'))
    <div class="mb-4 text-green-500">
        {{ session('success') }}
    </div>
    @endif

    <!-- Tombol Cetak Laporan -->
    <div class="mb-4 text-right">
        <button onclick="printTable()" class="px-6 py-2 bg-green-500 text-white rounded-lg shadow-md hover:bg-green-700 transition duration-200">Cetak Tabel</button>
    </div>

    <!-- Form Pilihan Tanggal -->
    <form action="{{ route('laporan.generate') }}" method="GET" class="mb-8 mt-5">
        <div class="flex flex-wrap justify-between space-y-4 sm:space-y-0 sm:flex-nowrap sm:space-x-4">
            <div>
                <label for="start_date" class="text-sm font-medium text-gray-600">Tanggal Mulai:</label>
                <input type="date" name="start_date" id="start_date" class="px-4 py-2 border border-gray-300 rounded-lg" value="{{ request('start_date') }}">
            </div>
            <div>
                <label for="end_date" class="text-sm font-medium text-gray-600">Tanggal Selesai:</label>
                <input type="date" name="end_date" id="end_date" class="px-4 py-2 border border-gray-300 rounded-lg" value="{{ request('end_date') }}">
            </div>
            <div>
                <label for="tipe" class="text-sm font-medium text-gray-600">Tipe:</label>
                <select name="tipe" id="tipe" class="px-4 py-2 border border-gray-300 rounded-lg">
                    <option value="">Semua</option>
                    <option value="in" {{ request('tipe') == 'in' ? 'selected' : '' }}>In</option>
                    <option value="out" {{ request('tipe') == 'out' ? 'selected' : '' }}>Out</option>
                </select>
            </div>
            <div class="flex items-end">
                <button type="submit" class="px-6 py-2 bg-blue-500 text-white rounded-lg shadow-md hover:bg-blue-700 transition duration-200">Generate Laporan</button>
            </div>
        </div>
    </form>

    <form method="get" action="mailto:{{ $emailAddress }}?subject={{ $subject }}">
        <button type="submit" class="my-3 px-6 py-2 bg-blue-500 text-white rounded-lg shadow-md hover:bg-blue-700 transition duration-200" >Kirim Email</button>
    </form>

    <!-- Tabel Transaksi -->
    <h2 class="text-lg font-semibold">Transaksi</h2>
    <div class="overflow-x-auto bg-white shadow-md rounded-lg mb-5">
        <table class="min-w-full table-auto">
            <thead>
                <tr class="bg-gray-200">
                    <th class="px-4 py-2 text-left text-sm font-medium text-gray-600">Nama Barang</th>
                    <th class="px-4 py-2 text-left text-sm font-medium text-gray-600">Tanggal</th>
                    <th class="px-4 py-2 text-left text-sm font-medium text-gray-600">Jumlah</th>
                    <th class="px-4 py-2 text-left text-sm font-medium text-gray-600">Diubah Oleh</th>
                    <th class="px-4 py-2 text-left text-sm font-medium text-gray-600">Tipe</th>
                </tr>
            </thead>
            <tbody>
                @if(isset($transaksi))
                @foreach ($transaksi as $trx)
                <tr class="border-t hover:bg-gray-50">
                    <td class="px-4 py-2 text-sm text-gray-700">{{ $trx->barang->nama_Barang }}</td>
                    <td class="px-4 py-2 text-sm text-gray-700">{{ $trx->tgl_transaksi }}</td>
                    <td class="px-4 py-2 text-sm text-gray-700">{{ $trx->jml_barang }}</td>
                    <td class="px-4 py-2 text-sm text-gray-700">{{ $trx->user->name }}</td>
                    <td class="px-4 py-2 text-sm text-gray-700">{{ ucfirst($trx->tipe) }}</td>
                </tr>
                @endforeach
                @endif
            </tbody>
        </table>
    </div>

    <!-- Total Barang Masuk dan Keluar -->
    @if(isset($transaksi))
    <div class="mt-3 mb-5">
        <h2 class="text-lg font-semibold text-gray-800">Rekapitulasi Barang</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Kartu Total Barang Masuk -->
            <div class="flex items-center bg-green-100 p-6 rounded-lg shadow-lg">
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Total Barang Masuk</p>
                    <p class="text-3xl font-bold text-green-800">{{ $totalBarangMasuk }} unit</p>
                </div>
            </div>

            <!-- Kartu Total Barang Keluar -->
            <div class="flex items-center bg-red-100 p-6 rounded-lg shadow-lg">
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Total Barang Keluar</p>
                    <p class="text-3xl font-bold text-red-800">{{ $totalBarangKeluar }} unit</p>
                </div>
            </div>
        </div>
    </div>
    @endif



    <!-- Barang Hampir Habis -->
    <h2 class="text-lg font-semibold">Barang Hampir Habis</h2>
    @if($barangAlmostOutOfStock->isEmpty())
    <p class="text-gray-600">Tidak ada barang yang hampir habis.</p>
    @else
    <div class="overflow-x-auto bg-white shadow-md rounded-lg">
        <table class="min-w-full table-auto">
            <thead>
                <tr class="bg-gray-200">
                    <th class="px-4 py-2 text-left text-sm font-medium text-gray-600">Nama Barang</th>
                    <th class="px-4 py-2 text-left text-sm font-medium text-gray-600">Stok</th>
                    <th class="px-4 py-2 text-left text-sm font-medium text-gray-600">Minimum Stok</th>
                </tr>
            </thead>
            <tbody>
                @foreach($barangAlmostOutOfStock as $item)
                <tr class="border-t">
                    <td class="px-4 py-2 text-sm text-gray-700">{{ $item->nama_Barang }}</td>
                    <td class="px-4 py-2 text-sm text-gray-700">{{ $item->stok }}</td>
                    <td class="px-4 py-2 text-sm text-gray-700">{{ $item->minimum_Stok }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @endif

    <!-- Barang Hampir Kadaluarsa -->
    <h2 class="text-lg font-semibold mt-5">Barang Hampir Kadaluarsa</h2>
    @if($barangExpiringSoon->isEmpty())
    <p class="text-gray-600">Tidak ada barang yang hampir kadaluarsa dalam 7 hari ke depan.</p>
    @else
    <div class="overflow-x-auto bg-white shadow-md rounded-lg">
        <table class="min-w-full table-auto">
            <thead>
                <tr class="bg-gray-200">
                    <th class="px-4 py-2 text-left text-sm font-medium text-gray-600">Nama Barang</th>
                    <th class="px-4 py-2 text-left text-sm font-medium text-gray-600">Tanggal Kadaluarsa</th>
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
    <h2 class="text-lg font-semibold mt-5">Barang Sudah Kadaluarsa</h2>
    @if($barangExpired->isEmpty())
    <p class="text-gray-600">Tidak ada barang yang sudah kadaluarsa.</p>
    @else
    <div class="overflow-x-auto bg-white shadow-md rounded-lg">
        <table class="min-w-full table-auto">
            <thead>
                <tr class="bg-gray-200">
                    <th class="px-4 py-2 text-left text-sm font-medium text-gray-600">Nama Barang</th>
                    <th class="px-4 py-2 text-left text-sm font-medium text-gray-600">Tanggal Kadaluarsa</th>
                </tr>
            </thead>
            <tbody>
                @foreach($barangExpired as $item)
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

</div>

<script>
    function printTable() {
        const printContent = document.getElementById('printableTable').innerHTML;
        const originalContent = document.body.innerHTML;
        document.body.innerHTML = printContent;
        window.print();
        document.body.innerHTML = originalContent;
        window.location.reload();
    }
</script>
@endsection