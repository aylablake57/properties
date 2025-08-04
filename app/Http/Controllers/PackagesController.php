<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Package;

class PackagesController extends Controller
{
    public function index(Request $request)
    {
        $packages = Package::all();
        $sellerPackages = $packages->where('user_type' , 'seller');
        $agentsPackages = $packages->where('user_type' , 'agent');
        $agencyPackages = $packages->where('user_type' , 'agency');

        return view('guest.pages.advertise', [
            'sellerPackages'    =>  $sellerPackages,
            'agentsPackages'    =>  $agentsPackages,
            'agencyPackages'    =>  $agencyPackages,
        ]);
    }
}
