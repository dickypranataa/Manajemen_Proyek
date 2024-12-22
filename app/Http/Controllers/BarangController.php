<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\Transaksi;
use Illuminate\Http\Request;
use Carbon\Carbon; // Pastikan untuk menambahkan Carbon
// use Illuminate\Container\Attributes\Auth;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;

class BarangController extends Controller
{
// Menampilkan daftar barang
    public function index(Request $request)
    {
        // Ambil semua barang
        $barang = Barang::query();
    
        // Jika ada parameter pencarian 'search', filter berdasarkan nama
        if ($request->has('search') && $request->search != '') {
            $barang = $barang->where('nama_Barang', 'like', '%' . $request->search . '%');
        }
    
        // Ambil data barang yang sudah difilter
        $barang = $barang->get();
    
        // Kirim data ke view
        return view('barang.index', compact('barang'));
    }


// Menampilkan form untuk ambil barang
    public function ambilBarang($id)
    {
        // Menampilkan detail barang berdasarkan ID
        $barang = Barang::findOrFail($id);
        return view('barang.ambil', compact('barang'));
    }

    public function updateStok(Request $request)
    {
        // Validasi input
        $validated = $request->validate([
            'nama_Barang' => 'required|string|max:255',
            'satuan' => 'required|string|max:50',
            'stok' => 'required|numeric|min:1',
        ]);

        // Update stok barang berdasarkan nama_barang
        $barang = Barang::where('nama_Barang',
            $request->nama_Barang
        )->first();

        if ($barang) {
            $barang->stok += $request->stok; // Menambahkan stok baru
            $barang->save();

            return redirect()->route('barang.index')->with('success', 'Stok berhasil diperbarui');
        }

        return back()->withErrors(['nama_Barang' => 'Barang tidak ditemukan']);
    }


// untuk notifikasi barang
    public function notifikasi()
    {
        // Ambil semua barang
        $barang = Barang::all();

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
        return view('barang.notifikasi', compact('barangAlmostOutOfStock', 'barangExpiringSoon', 'barangExpired'));
    }



// untuk bubble reminder notifikasi jika ada barang yang akan habis maupun kadaluarsa
    public function __construct()
    {
        // Ambil data barang hampir habis dan hampir kadaluarsa
        $barangAlmostOutOfStockCount = Barang::whereColumn('stok', '<=', 'minimum_Stok')->count();
        $barangExpiringSoonCount = Barang::whereBetween('tgl_kadaluarsa', [Carbon::now(), Carbon::now()->addDays(7)])->count();
        $barangExpiringCount = Barang::whereBetween('tgl_kadaluarsa', [Carbon::now(), Carbon::now()->addDays(7)])->count();

        // Total notifikasi
        $totalNotifications = $barangAlmostOutOfStockCount + $barangExpiringSoonCount;

        // Bagikan total notifikasi ke semua view
        View::share('totalNotifications', $totalNotifications);
    }



// Mengupdate stok setelah barang diambil
public function ambilStok(Request $request, $id)
{
    $userId = Auth::id();
    $jumlahDiminta = $request->input('jumlah');
    $namaBarang = $request->input('nama_Barang'); // Mengambil nama barang dari request

    // Cari barang berdasarkan nama dan urutkan berdasarkan tanggal kadaluarsa terdekat
    $barangs = Barang::where('nama_barang', $namaBarang)
        ->where('stok', '>', 0) // Pastikan hanya barang dengan stok tersedia yang dipilih
        ->orderBy('tgl_kadaluarsa', 'asc') // Urutkan berdasarkan tanggal kadaluarsa
        ->get();

    foreach ($barangs as $barang) {
        if ($jumlahDiminta <= 0) {
            break;
        }

        // Tentukan jumlah barang yang akan diambil berdasarkan stok yang tersedia
        $jumlahDiambil = min($jumlahDiminta, $barang->stok);

        // Buat transaksi pengambilan barang
        Transaksi::create([
            'tgl_transaksi' => Carbon::now(),
            'id_barang' => $barang->id_barang,
            'user_id' => $userId,
            'satuan' => $barang->satuan,
            'jml_barang' => $jumlahDiambil,
            'tipe' => "out",
        ]);

        // Kurangi stok barang
        $barang->stok -= $jumlahDiambil;
        $barang->save();

        // Kurangi jumlah yang diminta
        $jumlahDiminta -= $jumlahDiambil;

        $barangs = Barang::where('nama_barang', $namaBarang)
        ->get();
        foreach ($barangs as $item) {
            if ($item->stok == 0) {
                $item->delete();
            }
        }
    }

    // Jika jumlah yang diminta masih lebih besar dari 0 setelah loop selesai
    if ($jumlahDiminta > 0) {
        return redirect()->route('barang.index')->with('error', 'Stok tidak mencukupi!');
    }

    return redirect()->route('barang.index')->with('success', 'Barang berhasil diambil!');
}






    public function create()
    {
        $user = Auth::user();
        return view('barang.create', compact('user'));
    }

    public function show()
    {
        // $barang = Barang::pluck('nama_Barang');
        $barang = Barang::select('nama_Barang', 'satuan')->get();
        return view('barang.add_stok', compact('barang'));
    }



    // Menyimpan barang baru
    public function store(Request $request)
    {
        $userId = Auth::user()->id; // Mendapatkan ID pengguna yang sedang login

        // Validasi input dari form
        $request->validate([
            'nama_Barang' => 'required|string|max:255',
            'satuan' => 'required|string|max:255',
            'stok' => 'required|integer|min:0',
            'tgl_kadaluarsa' => 'required|date',
            'minimum_Stok' => 'required|integer|min:0',
        ]);

        // Simpan barang baru dengan input yang valid
        $barang = Barang::create([
            'nama_Barang' => $request->nama_Barang,
            'satuan' => $request->satuan,
            'stok' => $request->stok,
            'tgl_kadaluarsa' => $request->tgl_kadaluarsa,
            'minimum_Stok' => $request->minimum_Stok,
        ]);

        // Simpan data transaksi, menggunakan id_barang yang otomatis dihasilkan
        Transaksi::create([
            'tgl_transaksi' => Carbon::now(),
            'id_barang' => $barang->id_barang, // Mengambil id_barang yang baru saja disimpan
            'user_id' => $userId,
            'satuan' => $request->satuan,
            'jml_barang' => $request->stok,
            'tipe' => 'in',
        ]);

        // Redirect kembali ke daftar barang dengan pesan sukses
        return redirect()->route('barang.index')->with('success', 'Barang berhasil ditambahkan!');
    }


    // Menampilkan form untuk edit barang
    public function edit($id)
    {
        $barang = Barang::findOrFail($id);
        return view('barang.edit', compact('barang'));
    }

    // Menyimpan perubahan data barang
    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_Barang' => 'required|string|max:255',
            'satuan' => 'required|string|max:255',
            'stok' => 'required|integer|min:0',
            'tgl_kadaluarsa' => 'required|date',
            'minimum_Stok' => 'required|integer|min:0',
        ]);

        $barang = Barang::findOrFail($id);
        $barang->update($request->all());

        return redirect()->route('barang.index')->with('success', 'Barang berhasil diperbarui!');
    }

    // Menghapus barang
    public function destroy($id)
    {
        $barang = Barang::findOrFail($id);
        $barang->delete();

        return redirect()->route('barang.index')->with('success', 'Barang berhasil dihapus!');
    }
}