@extends('layouts.app')

@section('content')
<div class="container mx-auto mt-10 px-4">
    <!-- Header Dashboard -->
    <h1 class="text-3xl font-bold text-center mb-8 text-gray-800">Dashboard</h1>

    <!-- Pesan Selamat Datang -->
    <div class="text-center mb-6">
        <h2 class="text-2xl font-semibold text-gray-700">
            Selamat Datang, {{ Auth::user()->name }}!
        </h2>
    </div>

    <!-- Statistik Total -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
        <!-- Total Barang Masuk -->
        <div class="bg-green-500 text-white rounded-lg shadow-md p-6 text-center">
            <h2 class="text-lg md:text-xl font-semibold">Total Barang Masuk</h2>
            <p class="text-3xl md:text-4xl mt-2 font-bold">{{ $totalBarangMasuk }}</p>
            <a href="{{ route('barang.index') }}" class="text-sm hover:underline mt-2 inline-block">Lihat Barang</a>
        </div>

        <!-- Total Barang Keluar -->
        <div class="bg-red-500 text-white rounded-lg shadow-md p-6 text-center">
            <h2 class="text-lg md:text-xl font-semibold">Total Barang Keluar</h2>
            <p class="text-3xl md:text-4xl mt-2 font-bold">{{ $totalBarangKeluar }}</p>
            <a href="{{ route('transaksi.index') }}" class="text-sm hover:underline mt-2 inline-block">Lihat Transaksi</a>
        </div>

        <!-- Total Stok Gudang -->
        <div class="bg-blue-500 text-white rounded-lg shadow-md p-6 text-center">
            <h2 class="text-lg md:text-xl font-semibold">Total Stok Gudang</h2>
            <p class="text-3xl md:text-4xl mt-2 font-bold">{{ $totalStok }}</p>
            <a href="{{ route('barang.index') }}" class="text-sm hover:underline mt-2 inline-block">Lihat Stok</a>
        </div>

        <!-- Total User -->
        <div class="bg-purple-500 text-white rounded-lg shadow-md p-6 text-center">
            <h2 class="text-lg md:text-xl font-semibold">Total User</h2>
            <p class="text-3xl md:text-4xl mt-2 font-bold">{{ $totalUser }}</p>
            <a href="{{ route('users.index') }}" class="text-sm hover:underline mt-2 inline-block">Lihat User</a>
        </div>

        <!-- Total Notifikasi -->
        <div class="bg-yellow-400 text-white rounded-lg shadow-md p-6 text-center">
            <h2 class="text-lg md:text-xl font-semibold">Total Notifikasi</h2>
            <p class="text-3xl md:text-4xl mt-2 font-bold">{{ $totalNotifications }}</p>
            <a href="{{ route('users.index') }}" class="text-sm hover:underline mt-2 inline-block">Lihat User</a>
        </div>
    </div>

    <!-- Link ke Laporan -->
    <div class="mt-10 text-center">
        <a href="{{ route('laporan.index') }}" class="text-lg text-blue-500 hover:underline">Lihat Laporan</a>
    </div>

</div>

<!-- Diagram Transaksi Bulanan -->
<div class="mt-10 bg-white shadow-md rounded-lg p-4 sm:p-6">
    <h2 class="text-lg md:text-2xl font-bold mb-4 text-center">Diagram Transaksi Masuk & Keluar per Bulan</h2>
    <div class="w-full">
        <canvas id="monthlyTransactionChart" class="w-full"></canvas>
    </div>
</div>

<!-- Tabel Transaksi Terbaru -->
@if($user->role == 'admin' || $user->role == 'employee')
<div class="mt-10 bg-white shadow-md rounded-lg overflow-hidden">
    <div class="px-6 py-4 bg-gray-800 text-white">
        <h2 class="text-lg md:text-xl font-bold">5 Transaksi Terbaru</h2>
    </div>
    <div class="p-4 overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">No</th>
                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Jumlah Barang</th>
                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Tipe</th>
                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Tanggal</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @foreach ($transactions as $index => $transaksi)
                <tr>
                    <td class="px-4 py-2 whitespace-nowrap">{{ $index + 1 }}</td>
                    <td class="px-4 py-2 whitespace-nowrap">{{ $transaksi->jml_barang }}</td>
                    <td class="px-4 py-2 whitespace-nowrap">{{ ucfirst($transaksi->tipe) }}</td>
                    <td class="px-4 py-2 whitespace-nowrap">{{ $transaksi->created_at->format('d M Y H:i') }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endif

<!-- Script untuk Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    var monthlyData = @json($allMonthsData);

    var months = [];
    var totalIn = [];
    var totalOut = [];

    monthlyData.forEach(function(data) {
        months.push(data.month_name);
        totalIn.push(data.total_in);
        totalOut.push(data.total_out);
    });

    const ctx = document.getElementById('monthlyTransactionChart').getContext('2d');
    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: months,
            datasets: [{
                    label: 'Barang Masuk',
                    data: totalIn,
                    backgroundColor: '#22c55e'
                },
                {
                    label: 'Barang Keluar',
                    data: totalOut,
                    backgroundColor: '#ef4444'
                }
            ]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
</script>
@endsection