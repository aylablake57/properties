<?php

namespace App\Http\Controllers;

use App\Models\Agreement;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AgreementController extends Controller
{
    public function show(): View
    {
        return view('auth.agreement');
    }

    public function accept(Request $request): RedirectResponse
    {
        $user = Auth::user();

        if (!$user) {
            return redirect()->route('login');
        }

        // Validate the request
        $request->validate([
            'agree' => 'required|accepted',
            'agreement_text' => 'nullable',
        ]);

        // Create or update the agreement
        Agreement::updateOrCreate(
            ['user_id' => $user->id],
            [
                'name' => $user->name,
                'is_agreed' => true,
                'agreement_date' => now(),
                'agreement_text' => $request->agreement_text,
            ]
        );

        return redirect()->route('dashboard');
    }
}
