<?php

namespace App\Http\Controllers;

use App\Models\Transaksi;
use App\Models\Barang;
use Illuminate\Http\Request;

class TransaksiController extends Controller
{
    // Menampilkan daftar transaksi
    // Menampilkan daftar transaksi dengan filter tanggal dan tipe
    public function index() {
        return view('transaksi.index');
    }


    // Menampilkan form tambah transaksi
    public function generate(Request $request)
    {
        $query = Transaksi::with('barang', 'user'); // Mulai dengan query dasar

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

        return view('transaksi.index', compact('transaksi'));
    }
}
