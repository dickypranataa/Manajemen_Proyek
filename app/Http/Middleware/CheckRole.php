<?php

namespace App\Http\Middleware;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

use Illuminate\Support\Facades\Auth;

class CheckRole
{
    public function handle($request, Closure $next, ...$roles) : Response
    {
        // Periksa apakah pengguna sudah login
        if (!Auth::check()) {
            abort(404);
        }

        // Periksa apakah pengguna memiliki salah satu role
        if (!in_array(Auth::user()->role, $roles)) {
            // return redirect()->route('login')->with('error', 'Anda tidak memiliki akses ke halaman ini.');
            abort(404);
        }

        return $next($request);
    }
}

