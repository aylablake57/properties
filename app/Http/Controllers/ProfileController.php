<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use App\Models\City;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use File;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        $cities = City::all();

        return view('profile.edit', [
            'user'      =>  $request->user(),
            'cities'    =>  $cities
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $user = $request->user();

        $replac_ch = ['-'   =>  '', ' ' =>  '', '(' =>  '', ')' =>  ''];
        // $request->phone = strtr($request->phone , $replac_ch);

        $cleanPhone = strtr($request->phone, $replac_ch);

        // Check if phone number is changed
        $isPhoneChanged = $user->phone !== $cleanPhone;
    
        $user->fill($request->validated());
        $user->phone = $cleanPhone;

        //$user->name = $request->name;

        // Handle the image upload if an image is provided
        if ($request->hasFile('profile_image')) {
            $image = $request->file('profile_image');
            $destinationPath = 'users/' . $image->getClientOriginalName();
            Storage::disk('ftp')->putFileAs('', $image, $destinationPath);
            Storage::disk('ftp')->setVisibility($destinationPath, 'public');
            $user->profile_image = $destinationPath;
        }

        if ($isPhoneChanged) {
            $user->is_otp_verified = 0;
            $user->otp_verified_via = NULL;
        };

        $user->facebook_id = $request->facebook_id;
        $user->instagram = $request->instagram;
        $user->linkedin = $request->linkedin;
        $user->youtube = $request->youtube;
        $user->about = $request->about;

        $user->save();

        return Redirect::route('profile.edit')->with('status', 'Profile has been updated!');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
