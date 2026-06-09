<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class EnsureNoWaIsFilled
{
    public function handle(Request $request, Closure $next): Response
    {
        // Jika user sudah login dan kolom no_hp di database ternyata KOSONG (null/'')
        if (Auth::check() && empty(Auth::user()->no_hp)) {
            // Jika dia mencoba mengakses halaman selain form input no_hp, tendang ke halaman lengkapi-profil
            if (! $request->routeIs('profil.lengkapi', 'profil.update-nomor', 'logout')) {
                return redirect()->route('profil.lengkapi')->with('error', 'Anda harus mengisi no_hp terlebih dahulu!');
            }
        }

        return $next($request);
    }
}
