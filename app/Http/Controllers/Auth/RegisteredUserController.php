<?php

namespace App\Http\Controllers\Auth;

use App\Enums\UserType;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;
use Illuminate\Validation\Rule;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        $userTypes = UserType::cases();
        $excludedCases = [UserType::User, UserType::Buyer, UserType::SuperAdmin,  UserType::Admin];
        $userTypes = array_filter($userTypes, fn($userType) => !in_array($userType, $excludedCases));
        $userTypes = array_values($userTypes);


        return view('auth.register', compact('userTypes'));
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        if (in_array($request->user_type, [UserType::Agency->value, UserType::Agent->value])) {
            $request->validate([
                'name'      =>  ['required', 'string', 'max:255'],
                'email'     =>  ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:' . User::class],
                'phone'     =>  [
                    'required',
                    'string',
                    'max:10',
                    'regex:/^\d{10}$/'
                ],
                'password'  =>  [
                    'required',
                    'confirmed',
                    Rules\Password::min(8) // Require at least 8 characters...
                        ->mixedCase()
                        ->letters()
                        ->numbers()
                        ->symbols()
                    //->uncompromised(),
                ],
                'user_type'  =>  ['required', Rule::enum(UserType::class)],
                'cnic' => [
                    "regex:/^\d{5}-\d{7}-\d{1}$/",
                    Rule::requiredIf(in_array($request->user_type, [UserType::Agency->value, UserType::Agent->value])),
                ],
                'g-recaptcha-response' => 'required|recaptchav3:register,0.5'
            ]);
        } else {
            $request->validate([
                'name'      =>  ['required', 'string', 'max:255'],
                'email'     =>  ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:' . User::class],
                'phone'     =>  [
                    'required',
                    'string',
                    'max:10',
                    'regex:/^\d{10}$/'
                ],
                'password'  =>  [
                    'required',
                    'confirmed',
                    Rules\Password::min(8) // Require at least 8 characters...
                        ->mixedCase()
                        ->letters()
                        ->numbers()
                        ->symbols()
                    //->uncompromised(),
                ],
                'user_type'  =>  ['required', Rule::enum(UserType::class)],
                'g-recaptcha-response' => 'required|recaptchav3:register,0.5'
            ]);
        }

        $user = User::create([
            'name'        =>  $request->name,
            'email'       =>  $request->email,
            'phone'       =>  SmsCellPhoneNumber($request->phone),
            'password'    =>  Hash::make($request->password),
            'user_type'   =>  $request->user_type,
            'cnic_number' =>  $request->cnic,
        ]);

        Auth::login($user);

        return redirect(route('dashboard', absolute: false));
    }
}
