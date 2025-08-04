<?php

namespace App\Http\Controllers;

use App\Imports\PricesImport;
use App\Models\Price;
use App\Models\Property;
use App\Models\Ad;
use App\Enums\UserType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;

class UserDashboardController extends Controller
{
    public function create()
    {
        $myProperties = Property::where('user_id' , auth()->id())->get();
        $listings = null;
        $total = auth()->user()->user_type->propertyLimit();

        if (auth()->user()->hasRole('seller')) {
            $listings = Ad::where('user_id' , auth()->id())->get();
        }
        
        return view('user.dashboard', [
            'myProperties'  =>  $myProperties,
            'listings'      =>  $listings,
            'total'         =>  $total
        ]);
    }

    public function markAsRead($id)
    {
        $user = Auth::user();
        $notification = $user->notifications()->find($id);

        if ($notification) {
            $notification->markAsRead();
            return redirect()->back()->with('success', 'Notification marked as read.');
        }

        return redirect()->back()->with('error', 'Notification not found.');
    }

    public function import(Request $request)
    {
        if ($request->has('import_file')) {
            try {
                Excel::import(new PricesImport, $request->file('import_file'));
            } catch (\Maatwebsite\Excel\Validators\ValidationException $e) {
                $errors = [];
                $failures = $e->failures();
                foreach ($failures as $key => $failure) {
                    $errors[$key]['row'] = $failure->row(); // row that went wrong
                    $errors[$key]['attribute'] = $failure->attribute(); // either heading key (if using heading row concern) or column index
                    $errors[$key]['errors'] = $failure->errors(); // Actual error messages from Laravel validator
                    $errors[$key]['values'] = $failure->values(); // The values of the row that has failed.
                }
                return redirect()->route('import')->with('import_errors', $errors);
            }
        }

        $prices = Price::latest()->get();

        return view('user.index', ['prices' => $prices]);
    }
}
