<?php

namespace App\Http\Controllers;

use App\Models\City;
use Illuminate\Http\Request;

class MapController extends Controller
{
    public function index(Request $request)
    {
        $cities = City::all();

        if ($request->filled('location') && $request->filled('city')) {
            $phase = "phase-" . str_replace('Phase ' , '' , $request->location);

            if ($request->city == 1)
                $city = 'islamabad';
            elseif ($request->city == 2)
                $city = 'lahore';
                elseif ($request->city == 3) {
                $city = 'karachi';
                $phase = "city-sector-" . str_replace('Phase ' , '' , $request->location);
            }elseif ($request->city == 4)
                $city = 'multan';
            elseif ($request->city == 5)
                $city = 'peshawar';
            elseif ($request->city == 6)
                $city = 'bahawalpur';
            elseif ($request->city == 7)
                $city = 'gujranwala';
            elseif ($request->city == 8)
                $city = 'quetta';

            $path = "https://emap.pk/dha-" . $phase . "-" . $city . "-map";
        } else {
            $path = "https://emap.pk/";
        }

        return view('guest.pages.maps', [
            'cities' => $cities,
            'path'   =>  $path
        ]);
    }
}
