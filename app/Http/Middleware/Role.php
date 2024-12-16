<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Auth\Middleware\Role as Middleware;

class Role extends Middleware
{
    public function handle($request, Closure $next, ...$roles)
    {
        if (!Auth::check()) {
            return redirect()->route('admin.showLogin');
        }

        $user = Auth::user();

        // Cek apakah role user ada di daftar roles yang diizinkan
        if (in_array($user->role, $roles)) {
            return $next($request);
        }

        // Redirect atau tampilkan halaman terlarang
        return redirect()->route('admin.dashboard')->with('error', 'Anda tidak memiliki akses.');
    }
}
