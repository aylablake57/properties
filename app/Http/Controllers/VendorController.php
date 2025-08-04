<?php

namespace App\Http\Controllers;

use App\Models\Vendor;
use App\Models\City;
use Illuminate\Http\Request;

class VendorController extends Controller
{
    public function index(Request $request)
    {
        $companyTypes = Vendor::select('firm_category')->get()->unique('firm_category');

        $cities = City::all();

        $vendors = Vendor::select('*');

        //search by company type
        if ($request->filled('type')) {
            $vendors = $vendors->where('firm_category' , '=' , $request->type);
        }

        //search by city
        if ($request->filled('city')) {
            $vendors = $vendors->where('city_id', $request->city);
        }

        $vendors = $vendors->paginate(10);

        return view('guest.pages.vendors', [
            'companyTypes'  =>  $companyTypes,
            'cities'        =>  $cities,
            'vendors'       =>  $vendors,
            'search'        =>  $request->query()
        ]);
    }
}
