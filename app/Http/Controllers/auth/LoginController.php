<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class LoginController extends Controller
{


    // Menampilkan halaman login
    public function showLoginForm()
    {
        return view('auth.login');
    }

    // Proses login
    public function login(Request $request)
    {
        // Validasi data yang dimasukkan user
        $request->validate([
            'name' => 'required|string',
            'password' => 'required|string',
        ]);

        // Cek kredensial login
        if (Auth::attempt(['name' => $request->name, 'password' => $request->password])) {
            // Redirect ke halaman dashboard jika login berhasil
            return redirect()->route('dashboard.index');
        }

        // Jika login gagal, kembali ke halaman login dengan pesan error
        return back()->withErrors([
            'name' => 'name atau password salah.',
        ]);
    }

    // Logout
    public function logout()
    {
        Auth::logout();
        return redirect()->route('login');
    }
}
