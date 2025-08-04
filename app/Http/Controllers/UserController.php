<?php

namespace App\Http\Controllers;

use App\Http\Requests\Auth\UserRequest;
use App\Models\User;
use App\Models\City;
use App\Models\Role;
use Illuminate\Validation\Rules;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    public function index()
    {
        $users = User::where('user_type', 'admin')
                        ->whereNotNull('created_by')
                        ->orderBy('id' , 'DESC')
                        ->get();

        return view('admin.pages.users.list', compact('users'));
    }

    public function form($id = null)
    {
        $cities = City::all();

        //Edit form
        $user = null;
        if ($id) {
            $user = User::where(['id' => $id])->first();
        }

        return view('admin.pages.users.form', [
            'cities' => $cities,
            'user' => $user
        ]);
    }

    public function store(UserRequest $request)
    {
        $existinUserID = $request->has('user_id') ? $request->user_id : null;

        if ($existinUserID) {
            //for updating existing record
            $user = User::find($existinUserID);
        } else {
            $request->validate([
                'email'     =>  ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:' . User::class],
                'password'  =>  ['required', Rules\Password::defaults()],
            ]);

            //for creating record
            $user = new User();
        }

        $this->save($user, $request);

        $message = 'User details has been added!';
        if ($existinUserID) {
            $message = 'User details has been updated!';
        }

        return redirect()->route('admin.users.list')->with('status', $message);
    }

    private function save(User $user, Request $request)
    {
        $user->name = $request->name;
        $user->phone = SmsCellPhoneNumber($request->phone);
        $user->landline = $request->landline;
        $user->city_id = $request->city;
        $user->address = $request->address;
        $user->user_type = 'admin';
        // $user->role_id = 3;

        if ($request->has('email')) {
            $user->email = $request->email;
        }
        if ($request->has('password') && $request->password != '') {
            $user->password = $request->password;
        }

        if ($request->has('profile_image')) {
            if ($user->profile_image) {
                if (Storage::disk('ftp')->exists($user->profile_image)) {
                    Storage::disk('ftp')->delete($user->profile_image);
                }
            }
            
            $uploadedFilePath = $request->file('profile_image')->store('users', 'ftp');
            Storage::disk('ftp')->setVisibility($uploadedFilePath, 'public');
            
            $user->profile_image = $uploadedFilePath;
        }

        $user->created_by = auth()->id();
        $user->save();
        $user->assignRole('admin');
    }

    public function assignRole(Request $request, User $user, Role $role)
    {
        $user->assignRole($role);

        return redirect()->back()->with('success', 'Role assigned successfully.');
    }
}
