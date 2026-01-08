<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; // Tambahkan import ini
use Symfony\Component\HttpFoundation\Response;

class RoleManager
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next, $role): Response
    {
        // 1. Cek apakah user sudah login menggunakan Facade Auth
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        // 2. Cek apakah role user sesuai
        // Kita gunakan Auth::user() agar Intelephense tahu ini adalah objek User
        if (Auth::user()->role !== $role) {
            return $this->redirectUser(Auth::user()->role);
        }

        return $next($request);
    }

    /**
     * Redirect user berdasarkan role jika mencoba akses area terlarang.
     */
    private function redirectUser($role)
    {
        return match($role) {
            'admin' => redirect()->route('admin.dashboard'),
            'coach' => redirect()->route('coach.dashboard'),
            'client' => redirect()->route('client.dashboard'),
            default => redirect('/'),
        };
    }
}