<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class IsOTPVerified
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // check if auth user is superadmin then not need to verifying
        if (auth()->user()->hasRole('superadmin')) {
            return $next($request);
        }
        else if (\Auth::user()->is_otp_verified == 0) {
            if ($request->route()->getName() !== 'otp.verification') {
                return redirect()->route('otp.verification');
            }
        }
        return $next($request);
    }
}
