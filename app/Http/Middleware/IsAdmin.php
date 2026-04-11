<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class IsAdmin
{
    public function handle(Request $request, Closure $next): Response
    {
        // Cek apakah user sudah login DAN role-nya adalah 'admin'
        if (Auth::check() && Auth::user()->role === 'admin') {
            return $next($request); // Silakan masuk
        }

        // Jika bukan admin, tendang ke halaman dashboard biasa dengan pesan error
        return redirect()->route('dashboard')->with('error', 'Akses ditolak! Anda bukan Admin.');
    }
}