@extends('layouts.app')

@section('content')

<div class="container mx-auto px-6 py-8">
    <h1 class="text-3xl font-semibold text-center mb-10">Daftar Transaksi</h1>

    @if (session('success'))
    <div class="mb-4 text-green-500">
        {{ session('success') }}
    </div>
    @endif

    <!-- Form Filter Tanggal dan Tipe -->
    <form action="{{ route('transaksi.generate') }}" method="POST" class="mb-4">
        @csrf
        <div class="flex space-x-4">
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
            <button type="submit" class="px-6 py-2 bg-blue-500 text-white rounded-lg">Filter</button>
        </div>
    </form>

    @if(isset($transaksi))
    <div class="overflow-x-auto bg-white shadow-md rounded-lg">
        <table class="min-w-full table-auto">
            <thead>
                <tr class="bg-gray-200">
                    <th class="px-4 py-2 text-left text-sm font-medium text-gray-600">ID</th>
                    <th class="px-4 py-2 text-left text-sm font-medium text-gray-600">Barang</th>
                    <th class="px-4 py-2 text-left text-sm font-medium text-gray-600">Tanggal</th>
                    <th class="px-4 py-2 text-left text-sm font-medium text-gray-600">Jumlah</th>
                    <th class="px-4 py-2 text-left text-sm font-medium text-gray-600">Diubah</th>
                    <th class="px-4 py-2 text-left text-sm font-medium text-gray-600">Tipe</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($transaksi as $trx)
                <tr class="border-t hover:bg-gray-50">
                    <td class="px-4 py-2 text-sm text-gray-700">{{ $trx->id_transaksi }}</td>
                    <td class="px-4 py-2 text-sm text-gray-700">{{ $trx->barang->nama_Barang }}</td>
                    <td class="px-4 py-2 text-sm text-gray-700">{{ $trx->tgl_transaksi }}</td>
                    <td class="px-4 py-2 text-sm text-gray-700">{{ $trx->jml_barang }}</td>
                    <td class="px-4 py-2 text-sm text-gray-700">{{ $trx->user->name }}</td>
                    <td class="px-4 py-2 text-sm text-gray-700">{{ ucfirst($trx->tipe) }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="px-4 py-2 text-sm text-gray-700 text-center">Tidak ada transaksi untuk tanggal yang dipilih atau filter lainnya.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endif
@endsection
