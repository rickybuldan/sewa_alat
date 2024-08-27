<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class EnsureEmailIsVerified
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if (Auth::check() && !Auth::user()->hasVerifiedEmail()) {
            // Redirect ke halaman verifikasi email jika email belum diverifikasi
            return redirect()->route('verification.notice');
        }

        return $next($request);
    }
}
