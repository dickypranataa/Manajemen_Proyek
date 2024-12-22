<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
// Menampilkan daftar semua user
    public function index()
    {
        // Mengambil semua user dari database
        $users = User::all();
        $user = Auth::user();
        return view('users.index', compact('users', 'user'));
    }

// Menampilkan form untuk membuat user baru
    public function create()
    {
        return view('users.create');
    }

// Menyimpan user baru ke database
public function store(Request $request)
    {
        // Validasi data input
        $request->validate([
            'name' => 'required|string|max:255|unique:users,name',
            'password' => 'required|string|min:6',
            'role' => 'required|in:admin,employee,vendor',
        ]);

        // Membuat user baru dan menyimpannya ke database menggunakan create
        try {
            // Membuat user baru dan menyimpannya ke database
            User::create([
                'name' => $request->name,
                'password' => Hash::make($request->password),
                'role' => $request->role,
            ]);
    
            // Redirect ke halaman daftar user dengan pesan sukses
            return redirect()->route('users.index')->with('success', 'User berhasil ditambahkan');
        } catch (\Exception $e) {
            // Menangani error dan mengarahkan kembali dengan pesan error
            return redirect()->back()->with('error', 'Terjadi kesalahan saat menambahkan user: ' . $e->getMessage());
        }

        // Redirect ke halaman daftar user dengan pesan sukses
        return redirect()->route('users.index')->with('success', 'User berhasil ditambahkan');
    }



// Menampilkan form untuk mengedit user
    public function edit($id)
    {
        $user = User::findOrFail($id); // Mencari user berdasarkan ID
        return view('users.edit', compact('user'));
    }

// Menyimpan perubahan user yang sudah diedit
    public function update(Request $request, $id)
    {
        // Validasi data input
        $request->validate([
            'name' => 'required|string|max:255',
            'password' => 'nullable|string|min:6', // Password opsional
            'role' => 'required|in:admin,employee,vendor',
        ]);

        // Mencari user berdasarkan ID dan memperbarui data
        $user = User::findOrFail($id);
        $user->name = $request->name;

        // Jika password diisi, perbarui password
        if ($request->password) {
            $user->password = Hash::make($request->password);
        }

        $user->role = $request->role;
        $user->save();

        // Redirect ke halaman daftar user dengan pesan sukses
        return redirect()->route('users.index')->with('success', 'User berhasil diperbarui');
    }

// Menghapus user
    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        // Redirect ke halaman daftar user dengan pesan sukses
        return redirect()->route('users.index')->with('success', 'User berhasil dihapus');
    }
}
