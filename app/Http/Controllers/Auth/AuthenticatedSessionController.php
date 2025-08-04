<?php

namespace App\Http\Controllers\Auth;

use App\Enums\UserType;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use PhpOffice\PhpSpreadsheet\Calculation\MathTrig\Absolute;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $remember_me = $request->has('remember_me') ? true : false;

        $request->authenticate();

        $request->session()->regenerate();

        $user = Auth::user();
        if ($user) {
            if ($user->hasRole(['admin', 'superadmin'])) {
                return redirect()->intended(route('admin.dashboard', absolute: false));
            } else {
                if (trim($user->is_otp_verified) == 0) {
                    return redirect('otp-verification');
                } else {
                    return redirect()->intended(route('dashboard', absolute: false));
                }
            }
        } else {
            return redirect()->route('login')->withErrors(['error' => 'Authentication failed']);
        }
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
