<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\ChangePasswordRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class PasswordController extends Controller
{
    /**
     * Update the user's password.
     */
    public function update(ChangePasswordRequest $request): RedirectResponse
    {
        // By Asfia
        $request->user()->update([
            'password' => Hash::make($request->password),
        ]);

        return back()->with('status', 'Password has been updated!');
    }
}
