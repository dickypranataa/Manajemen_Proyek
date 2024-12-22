<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    // Menampilkan halaman register
    public function showRegisterForm()
    {
        return view('auth.register');
    }

    // Proses registrasi
    public function register(Request $request)
{

    // Validasi data input
    $request->validate([
        'name' => 'required|string|max:255|unique:users,name',
        'password' => 'required|string|min:6',
        'role' => 'required|in:admin,employee,vendor',
    ]);

    try {
        // Membuat user baru dan menyimpannya ke database
        User::create([
            'name' => $request->name,
            'password' => Hash::make($request->password),
            'role' => $request->role,
        ]);

        // Redirect ke halaman login dengan pesan sukses
        return redirect()->route('login')->with('success', 'User berhasil ditambahkan');
    } catch (\Exception $e) {
        // Menangani error dan mengarahkan kembali dengan pesan error
        return redirect()->back()->with('error', 'Terjadi kesalahan saat menambahkan user: ' . $e->getMessage());
    }
}

}