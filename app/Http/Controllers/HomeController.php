<?php

namespace App\Http\Controllers;

use App\Models\{
    City,
    Feedback,
    Location,
    User,
    Property,
    PropertySubType,
    PropertyType as ModelsPropertyType,
    Subtype,
};
use App\Models\UserSearchLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Http\Requests\ContactRequest;
use Illuminate\Support\Str;
use Carbon\Carbon;
use App\Mail\GeneralEmail;
use Exception;
use Illuminate\Support\Facades\Cookie;
use DB;

class HomeController extends Controller
{
    public function index()
    {
        $propertyTypes = ModelsPropertyType::all();
        $cities = City::all();

        $propertiesByCities = City::select('id', 'name')
            ->withCount(['properties as properties_count' => function ($query) {
                $query->where('publish_status', 'Approved')
                    ->where('is_sold', 0);
            }])->get();

        $propertiesByTypes = Property::selectRaw('count(*) as type_count, type')
            ->where('publish_status', 'Approved')
            ->where('is_sold', '0')
            ->groupBy('type')
            ->get()

            ->sortByDesc('type_count');

        $newProjects = Property::where('publish_status', 'Approved')->take(10)
            ->orderByDesc('created_at')
            ->get();

        $propertiesByDHA = Property::join('users', 'properties.user_id', 'users.id')
            ->select('properties.*')
            ->whereHas('user.roles', function ($query) {
                $query->where('id', 3);
            })
            ->where('publish_status', 'Approved')
            ->orderByDesc('properties.created_at')
            ->take(10)
            ->get();


        // By Asfia
        $feedbacks = Feedback::where('status', 'Approved')
            ->orderByRaw('RAND()')->take(5)->get();

        return view('guest.pages.home', [
            'types'             => $propertyTypes,
            'cities'            => $cities,
            'propertiesByCities' => $propertiesByCities,
            'propertiesByTypes' => $propertiesByTypes,
            'newProjects'       => $newProjects,
            'propertiesByDHA'   =>  $propertiesByDHA,
            'feedbacks'         =>  $feedbacks,
        ]);
    }

    public function search(Request $request)
    {
        $propertyTypes = ModelsPropertyType::all();
        $cities = City::all();
        $properties = [];

        $properties = Property::query()
            ->where('publish_status', 'Approved')
            ->where(function ($query) {
                $query->where('is_sold', 0)
                    ->orWhereNull('is_sold');
            })->latest();
        $filtered = $this->searchProperties(search: $request, data: $properties);

        if (!$filtered['isSearchEmpty']) {
            $properties = $filtered['properties']->paginate(9);

            $city = City::find($request->input('city'));
            $location = Location::find($request->input('location'));
            $propertyType = \App\Models\PropertyType::find($request->input('type'));
            $subType = Subtype::find($request->input('sub_type'));

            UserSearchLog::create([
                'search_query' => $city ? $city->name : 'null',
                'location' => $location ? $location->name : 'all',
                'type' => $propertyType ? $propertyType->name : 'all',
                'sub_type' => $subType ? $subType->name : 'all',
            ]);
        } else {
            $properties = Property::paginate(9, ['*'], 'page', 1);
        }
        // Get similar properties
        //$similarProperties = [];
        $similarProperties = collect([]);
        if ($request->filled('city') && $properties->isNotEmpty()) {
            $similarProperties = Property::where('publish_status', 'Approved')
                ->where('is_sold', false)  //New Code Added By Yousaf to Exclude sold properties
                ->where('city_id', $request->city)
                ->whereNotIn('id', $properties->pluck('id')->toArray())
                ->take(5)
                ->orderByDesc('created_at')
                ->get();
        }

        return view('guest.pages.search', [
            'types' => $propertyTypes,
            'cities' => $cities,
            'properties' => $properties,
            'similarProperties' => $similarProperties,
            'search' => $request->query()
        ]);
    }

    private function searchProperties($search, $data)
    {
        $emptySearchValues = true;

        //search by city
        if ($search->filled('city')) {
            $emptySearchValues = false;
            $data = $data->where('city_id', $search->city);
        }

        //search by location
        if ($search->filled('location') && $search->location != 'all') {
            $emptySearchValues = false;
            $data = $data->where('location_id', $search->location);
        }

        //search by property type
        if ($search->filled('type') && $search->type != 'all') {
            $emptySearchValues = false;
            $data = $data->where('type', $search->type);
        }

        //search by property sub type
        if ($search->filled('sub_type') && $search->sub_type != 'all') {
            $emptySearchValues = false;
            $data = $data->where('sub_type', $search->sub_type);
        }

        //search by price range
        if ($search->filled('min_price') && $search->filled('max_price')) {
            if ($search->input('min_price') != 0 || $search->input('max_price') != 0) {
                $emptySearchValues = false;
                $data = $data->where('price', '>=', $search->input('min_price'));
                $data = $data->where('price', '<=', $search->max_price);
            }
        }

        // search by area range
        if ($search->filled('max_area') && $search->filled('min_area')) {
            if ($search->input('min_area') != 0 || $search->input('max_area') != 0) {
                $emptySearchValues = false;
                $data = $data->where('area_size', '<=', $search->max_area)
                    ->where('area_unit', 'marla');
                $data = $data->where('area_size', '>=', $search->min_area)
                    ->where('area_unit', 'marla');
            }
        }

        // search by area size and area unit
        if ($search->filled('size') && $search->filled('unit')) {
            $emptySearchValues = false;
            $data = $data->where('area_size', '=', $search->size)
                ->where('area_unit', $search->unit);
        }

        //search by installments
        if ($search->filled('installments')) {
            $emptySearchValues = false;
            $data = $data->where('installments_available', '1');
        }

        //search by amenities
        if ($search->filled('amenities')) {
            $emptySearchValues = false;
            $amenities = $search->input('amenities');
            $data = $data->whereHas('amenities', function ($query) use ($amenities) {
                $query->whereIn('amenity_id', array_keys($amenities));
            });
        }

        if ($search->query('price')) {
            $data = $data->orderBy('price', $search->query('price'));
        }

        return [
            'properties' => $data,
            'isSearchEmpty' => $emptySearchValues
        ];
    }

    public function trend(Request $request)
    {
        $city = $request->get('city');

        // Get the last 6 months
        $months = [];
        for ($i = 5; $i >= 0; $i--) {
            $months[] = Carbon::now()->subMonths($i)->format('Y-m');
        }

        // Fetch data from the database
        $data = UserSearchLog::select(DB::raw('DATE_FORMAT(created_at, "%Y-%m") as month'), DB::raw('count(*) as count'))
            ->where('search_query', $city)
            ->whereBetween('created_at', [Carbon::now()->subMonths(5)->startOfMonth(), Carbon::now()->endOfMonth()])
            ->groupBy('month')
            ->pluck('count', 'month')
            ->toArray();

        // Ensure data for all 6 months is present, default to 0 if not
        $yValues = [];
        foreach ($months as $month) {
            $yValues[] = $data[$month] ?? 0;
        }

        return response()->json([
            'xValues' => $months,
            'yValues' => $yValues,
        ]);
    }

    public function contact(ContactRequest $request)
    {
        if (substr($request->mobile, 0, 1) === '0') {
            $request->mobile = substr($request->mobile, 1);
        }

        $mailData = [
            'name'    => $request->name,
            'mobile'  => "+92" . $request->mobile,
            'email'   => $request->email,
            'message' => $request->message,
        ];

        // Added by Asfia
        $view = 'templates.contact';
        $subject = Str::title(str_replace('-', ' ', $request->complaintType));

        try {
            Mail::to(env('MAIL_FROM_ADDRESS'))->send(new GeneralEmail($subject, $view, $mailData));
            return redirect()->back()->with('check_contact', "<div class='rounded alert alert-success'>Thanks for contacting us. We will reach out soon</div>");
        } catch (Exception $e) {
            return redirect()->back()->with('check_contact', "<div class='rounded alert alert-danger'>Something went wrong during sending your query. Try Again !!</div>");
        }
    }

    public function propertiesByCities(Request $request)
    {
        $propertiesByCities = Property::select('city_id', DB::raw('count(id) as properties_count'), DB::raw('MONTH(created_at) as month'))
            ->where(DB::raw('EXTRACT(YEAR FROM created_at)'), '=', DB::raw('EXTRACT(YEAR FROM curdate())'))
            //->where('city_id' , $request->city_id)
            ->groupBy('city_id', DB::raw('MONTH(created_at)'))->get();
        /* $count = [];
        $months = [];

        foreach($propertiesByCities as $prop) {
            array_push($count , $prop->properties_count);
            array_push($months , $prop->month);
        }

        $data = [
            'counts'   =>  $count,
            'months'   =>  $months,
        ]; */

        echo json_encode($propertiesByCities);
    }
    //Code added by Asim : Sends user search logs for high cart demographics.
    public function sendUserlogs(Request $request)
    {
        // Fetch the user logs and aggregate counts by search_query
        $searchData = UserSearchLog::select('search_query')
            ->groupBy('search_query')
            ->selectRaw('count(*) as count')
            ->get();

        // Prepare data for Highcharts (Pie Chart)
        $locationWiseData = [];
        foreach ($searchData as $data) {
            $locationWiseData[] = ['name' => $data->search_query, 'y' => (int) $data->count];
        }

        // Prepare data for Spline Chart (e.g., hourly counts)
        $searchCountsByHour = UserSearchLog::select(
            DB::raw('DATE(created_at) as date'),
            DB::raw('HOUR(created_at) as hour'),
            DB::raw('count(*) as count')
        )
            ->groupBy('date', 'hour')
            ->orderBy('date')
            ->orderBy('hour')
            ->get();

        $splineData = [];
        foreach ($searchCountsByHour as $data) {
            $timestamp = Carbon::createFromFormat('Y-m-d H', $data->date . ' ' . $data->hour)->timestamp * 1000; // convert to milliseconds
            $splineData[] = [$timestamp, (int) $data->count];
        }

        // Check if the request is an AJAX request
        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'searchdata' => $searchData,
            ]);
        }

        // If not an AJAX request, return the view with data
        return view('guest.partials.trends', [
            'userlogs' => $searchData,
            'locationWiseData' => $locationWiseData, // Data for Pie Chart
            'splineData' => $splineData, // Data for Spline Chart
        ]);
    }

    public function fetchLatestSearchCount(Request $request)
    {
        // Get the latest search count for the current time period (e.g., last hour)
        $latestCount = UserSearchLog::where('created_at', '>=', now()->subHour())
            ->count();

        return response()->json([
            'searchCount' => $latestCount,
        ]);
    }

    // By Asfia
    public function fetchTrends()
    {
        $cities = City::with('locations')
            ->get()
            ->map(function ($city) {
                return [
                    'city_name' => $city->name,
                    'city_id' => $city->id,
                    'locations' => $city->locations->map(function ($location) {
                        return [
                            'id' => $location->id,
                            'name' => $location->name,
                        ];
                    }),
                ];
            });

        $types = ModelsPropertyType::pluck('id', 'name');
        $search_log = DB::table('user_search_logs')->select('search_query', DB::raw('COUNT(*) as search_count'))
            ->groupBy('search_query')
            ->orderBy('search_count', 'DESC')
            ->get()
            ->filter(function ($log) {
                return !is_null($log->search_query) && $log->search_query !== ''; // Filter out null or empty search queries
            });

        return view('guest.pages.fetch-trends', [
            'search_log' => $search_log,
            'cities' => $cities,
            'types' => $types,
        ]);
    }
}
