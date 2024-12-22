<?php

namespace App\Http\Controllers;

use App\Models\Transaksi;
use App\Models\Barang;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade as PDF;

class LaporanController extends Controller
{
    // Menampilkan form laporan
    public function index(){
        $barang = Barang::all();
        $emailAddress = 'support@example.com'; // Email penerima
        $subject = 'Dukungan Pelanggan'; // Subjek email

        // Filter barang dengan stok rendah
        $barangAlmostOutOfStock = $barang->filter(function ($item) {
            return $item->stok <= $item->minimum_Stok; // Barang yang stoknya <= minimum_Stok
        });

        // Filter barang dengan kadaluarsa dalam waktu 7 hari
        $barangExpiringSoon = $barang->filter(function ($item) {
            $expiryDate = Carbon::parse($item->tgl_kadaluarsa);
            $now = Carbon::now();
            $sevenDaysFromNow = $now->copy()->addDays(7);

            // Barang akan masuk jika tanggal kadaluarsa berada antara sekarang dan 7 hari ke depan
            return $expiryDate->greaterThanOrEqualTo($now) && $expiryDate->lessThanOrEqualTo($sevenDaysFromNow);
        });

        // Filter barang yang sudah kadaluarsa
        $barangExpired = $barang->filter(function ($item) {
            $expiryDate = Carbon::parse($item->tgl_kadaluarsa);
            $now = Carbon::now();

            // Barang dianggap expired jika tanggal kadaluarsanya kurang dari sekarang
            return $expiryDate->lessThan($now);
        });


        // Kirim data ke view
        return view('laporan.index', compact('barangAlmostOutOfStock', 'barangExpiringSoon', 'barangExpired', 'emailAddress', 'subject'));
    }


// Menghasilkan laporan berdasarkan tanggal yang dipilih
public function generate(Request $request)
{
        $query = Transaksi::with('barang', 'user'); // Mulai dengan query dasar
        $emailAddress = 'support@example.com'; // Email penerima
        $subject = 'Dukungan Pelanggan'; // Subjek email

        // Filter berdasarkan start_date dan end_date
        if ($request->has('start_date') && $request->has('end_date')) {
            $query->whereBetween('tgl_transaksi', [$request->start_date, $request->end_date]);
        }

        // Filter berdasarkan tipe (in/out)
        if ($request->has('tipe') && in_array($request->tipe, ['in', 'out'])) {
            $query->where('tipe', $request->tipe);
        }

        // Ambil data transaksi berdasarkan filter
        $transaksi = $query->get();

        // Data kadaluarsa tetap di-fetch tanpa filter
        $barangAlmostOutOfStock = Barang::whereColumn('stok', '<=', 'minimum_stok')->get();
        $barangExpiringSoon = Barang::where('tgl_kadaluarsa', '<=', now()->addDays(7))
            ->where('tgl_kadaluarsa', '>', now())
            ->get();
        $barangExpired = Barang::where('tgl_kadaluarsa', '<', now())->get();

        // Hitung total barang masuk dan keluar
        $totalBarangMasuk = $transaksi->where('tipe', 'in')->sum('jml_barang');
        $totalBarangKeluar = $transaksi->where('tipe', 'out')->sum('jml_barang');

        return view('laporan.index', compact('transaksi', 'barangAlmostOutOfStock', 'barangExpiringSoon', 'barangExpired', 'totalBarangMasuk', 'totalBarangKeluar', 'emailAddress', 'subject'));
}


}