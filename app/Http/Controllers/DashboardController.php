<?php

namespace App\Http\Controllers;

use App\Models\Transaksi;
use App\Models\User;
use App\Models\Barang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon; // Pastikan untuk menambahkan Carbon


class DashboardController extends Controller
{
    public function index()
    {
        // Mengambil total barang masuk
        $user = Auth::user();
        $totalBarangMasuk = Transaksi::where('tipe', 'in')->sum('jml_barang');

        // Mengambil total barang keluar
        $totalBarangKeluar = Transaksi::where('tipe', 'out')->sum('jml_barang');

        // Menghitung total stok gudang
        $totalStok = $totalBarangMasuk - $totalBarangKeluar;

        // Menghitung total user
        $totalUser = User::count();

        // Mengambil 5 transaksi terbaru
        $transactions = Transaksi::latest()->take(5)->get();

        // Mengambil transaksi berdasarkan bulan dan tahun, bahkan jika tidak ada transaksi di bulan tersebut
        $monthlyData = Transaksi::select(
            DB::raw('YEAR(tgl_transaksi) as year'),
            DB::raw('MONTH(tgl_transaksi) as month'),
            DB::raw('SUM(CASE WHEN tipe = "in" THEN jml_barang ELSE 0 END) as total_in'),
            DB::raw('SUM(CASE WHEN tipe = "out" THEN jml_barang ELSE 0 END) as total_out')
        )
            ->groupBy(DB::raw('YEAR(tgl_transaksi), MONTH(tgl_transaksi)'))
            ->orderBy(DB::raw('YEAR(tgl_transaksi), MONTH(tgl_transaksi)'), 'asc')
            ->get();

        // Menyiapkan array untuk bulan yang lengkap dari Januari hingga Desember
        $monthsOfYear = [
            '01' => 'January',
            '02' => 'February',
            '03' => 'March',
            '04' => 'April',
            '05' => 'May',
            '06' => 'June',
            '07' => 'July',
            '08' => 'August',
            '09' => 'September',
            '10' => 'October',
            '11' => 'November',
            '12' => 'December'
        ];

        // Menyiapkan data bulan yang lengkap
        $allMonthsData = [];
        for ($month = 1; $month <= 12; $month++) {
            $formattedMonth = str_pad($month, 2, '0', STR_PAD_LEFT);
            $data = $monthlyData->firstWhere('month', $formattedMonth);

            // Jika tidak ada data untuk bulan tersebut, set 0
            $totalIn = $data ? $data->total_in : 0;
            $totalOut = $data ? $data->total_out : 0;

            $allMonthsData[] = [
                'month' => $formattedMonth,
                'month_name' => $monthsOfYear[$formattedMonth],
                'total_in' => $totalIn,
                'total_out' => $totalOut,
            ];

            $barangAlmostOutOfStockCount = Barang::whereColumn('stok', '<=', 'minimum_Stok')->count();
            $barangExpiringSoonCount = Barang::whereBetween('tgl_kadaluarsa', [Carbon::now(), Carbon::now()->addDays(7)])->count();
            $barangExpiringCount = Barang::whereBetween('tgl_kadaluarsa', [Carbon::now(), Carbon::now()->addDays(7)])->count();

            // Total notifikasi
            $totalNotifications = $barangAlmostOutOfStockCount + $barangExpiringSoonCount;
        }

        // Kirim data ke view
        return view('dashboard', compact('totalBarangMasuk', 'totalBarangKeluar', 'totalStok', 'totalUser', 'transactions', 'allMonthsData', 'user', 'totalNotifications'));
    }
}
