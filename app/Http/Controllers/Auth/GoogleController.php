<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;
use App\Models\User;
use Illuminate\Support\Facades\Session;

use Exception;

class GoogleController extends Controller
{
    public function index(Request $request) {
        Session::forget('user_type');
        $validated = $request->validate([
            'user_type' => 'required|in:seller,agent,agency'
        ]);
        $user_type = $request->query('user_type');
        Session::put('user_type', $user_type);
        return socialite::driver('google')->redirect();
    }

    public function google_login() {
        return socialite::driver('google')->redirect();
    }

    public function google_register() {
        try {
            $user = Socialite::driver('google')->user();
            $finduser = User::where('email', $user->email)->first();
            if($finduser) {
                Auth::login($finduser);
                return redirect()->intended('dashboard');
            } else {
                if (Session::has('user_type')) {
                    $newUser = User::create([
                        'name'            => $user->name,
                        'email'           => $user->email,
                        'google_id'       => $user->id,
                        'user_type'       => Session::get('user_type'),
                        'password'        => encrypt(uniqid()),
                        "otp_code"        =>    NULL,
                        "email_otp_code"  =>    NULL,
                        "otp_verified_via" =>   "email",
                        "is_otp_verified" =>    1
                    ]);
                    Auth::login($newUser);
                    return redirect()->intended('dashboard');
                } else {
                    return redirect('register')->with('social_auth_status', '<div class="bg-danger text-white border rounded p-3">User account not found. Please register or sign up with google to continue</div>');
                }
            }
            Session::forget('user_type');
        } catch (Exception $e) {
            Session::forget('user_type');
            return redirect('register')->with('social_auth_status', '<div class="bg-danger text-white border rounded p-3">Something went wrong. Try again in few minutes</div>');
            // dd($e->getMessage());
        }

    }
}
