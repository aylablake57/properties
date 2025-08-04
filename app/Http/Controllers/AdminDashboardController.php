<?php

namespace App\Http\Controllers;

use App\Http\Requests\ResetPasswordRequest;
use App\Models\Ad;
use App\Models\Property;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AdminDashboardController extends Controller
{
    public function create()
    {

        $total = Property::all()->count();
        $totalMonth = Property::where(DB::raw('EXTRACT(YEAR_MONTH FROM created_at)'), '=', DB::raw('EXTRACT(YEAR_MONTH FROM curdate())'))
            ->count();
        $totalYear = Property::whereYear('created_at', now()->year)->count();
        $previousMonth = Carbon::now()->subMonth();
        $totalPreviousMonth = Property::whereYear('created_at', $previousMonth->year)
            ->whereMonth('created_at', $previousMonth->month)
            ->count();

        $approved = Property::where('publish_status', 'Approved')->count();
        $approvedMonth = Property::where('publish_status', 'Approved')
            ->where(DB::raw('EXTRACT(YEAR_MONTH FROM created_at)'), '=', DB::raw('EXTRACT(YEAR_MONTH FROM curdate())'))
            ->count();
        $approvedLastMonth = Carbon::now()->subMonth();
        $approvedPreviousMonth = Property::where('publish_status', 'Approved')->whereYear('created_at', $approvedLastMonth->year)
                ->whereMonth('created_at', $approvedLastMonth->month)
                ->count();
        $approvedYear = Property::where('publish_status', 'Approved')->whereYear('created_at', now()->year)->count();
        $cancel = Property::where('publish_status', 'Cancel')->count();
        $cancelMonth = Property::where('publish_status', 'Cancel')
            ->where(DB::raw('EXTRACT(YEAR_MONTH FROM created_at)'), '=', DB::raw('EXTRACT(YEAR_MONTH FROM curdate())'))
            ->count();
        $cancelLastMonth = Carbon::now()->subMonth();
        $cancelPreviousMonth = Property::where('publish_status', 'Cancel')->whereYear('created_at', $cancelLastMonth->year)
                    ->whereMonth('created_at', $cancelLastMonth->month)
                    ->count();
        $cancelYear = Property::where('publish_status', 'Cancel')->whereYear('created_at', now()->year)->count();

        //Code added by Asim to get sold property data
        $sold = Property::where('is_sold', 1)->count();
        $soldMonth = Property::where('is_sold', 1)
            ->where(DB::raw('EXTRACT(YEAR_MONTH FROM sold_on)'), '=', DB::raw('EXTRACT(YEAR_MONTH FROM curdate())'))
            ->count();
        $soldLastMonth = Carbon::now()->subMonth();
        $soldPreviousMonth = Property::where('is_sold', 1)->whereYear('sold_on', $soldLastMonth->year)
                    ->whereMonth('sold_on', $cancelLastMonth->month)
                    ->count();
        $soldYear = Property::where('is_sold', 1)->whereYear('sold_on', now()->year)->count();

        $notifications = auth()->user()->notifications;

        // Add counts for Ads and users with their statuses
        $adsCounts = getCountsAds();
        return view('admin.pages.dashboard', [
            'total'         =>  $total,
            'totalMonth'    =>  $totalMonth,
            'totalPreviousMonth' => $totalPreviousMonth,
            'totalYear'     =>  $totalYear,
            'approved'      =>  $approved,
            'approvedMonth' =>  $approvedMonth,
            'approvedPreviousMonth' => $approvedPreviousMonth,
            'approvedYear'  =>  $approvedYear,
            'cancel'        =>  $cancel,
            'cancelMonth'   =>  $cancelMonth,
            'cancelPreviousMonth' => $cancelPreviousMonth,
            'cancelYear'    =>  $cancelYear,
            'sold'        =>  $sold,
            'soldMonth'   =>  $soldMonth,
            'soldPreviousMonth' => $soldPreviousMonth,
            'soldYear'    =>  $soldYear,
            'notifications'  => $notifications,
            'adsCounts'       => $adsCounts,
        ]);
    }

    // By Asfia
    public function filterUser(Request $request)
    {
        $search = $request->input('searchItem');
        $results = User::where('name', 'like', "%{$search}%")
                        ->orWhere('email', 'like', "%{$search}%")
                        ->get();

        return view('profile.userPassReset', ['results' => $results]);
    }

    // function added to view page, added by Hamza Amjad
    public function  resetPasswordRest()
    {
        $users = User::select('id', 'name', 'phone', 'email')->paginate(10);
        return view('profile.userPassReset', ['results' => null]);
    }

    // By Asfia
    public function resetPassword(ResetPasswordRequest $request)
    {
        $user = User::find($request->input('userID'));

        if (!$user) {
            return redirect()->back()
                ->withErrors(['userID' => 'User could not be found.'])
                ->withInput();
        }

        $user->password = Hash::make($request->input('newPassword'));

        if ($user->save()) {
            return redirect()->back()->with('status', 'Password updated successfully.');
        } else {
            return redirect()->back()->with('status', 'Password could not be updated. Please try again later.');
        }
    }

    //Function modified by Asim > Now sends sold data to line chart as well
    public function lineChart(Request $request)
    {
        $categories = [];
        $totalValues = [];
        $totalApproved = [];
        $totalCancel = [];
        $totalSold = [];

        if ($request->duration == 'this month') {
            $properties = Property::select(DB::raw('DATE_FORMAT(created_at , "%D %M") as date'), DB::raw('COUNT(*) as total') )
                ->where(DB::raw('EXTRACT(YEAR_MONTH FROM created_at)'), '=', DB::raw('EXTRACT(YEAR_MONTH FROM curdate())'))
                ->groupBy('date')
                ->orderBy(DB::raw('STR_TO_DATE(date , "%D %M")'))
                ->get();
        } elseif ($request->duration == 'last month') {
            $properties = Property::select(DB::raw('DATE_FORMAT(created_at , "%D %M") as date'), DB::raw('COUNT(*) as total'))
                ->where(DB::raw('EXTRACT(YEAR_MONTH FROM created_at)'), '=', DB::raw('EXTRACT(YEAR_MONTH FROM curdate()) - 1'))
                ->groupBy('date')->orderBy(DB::raw('STR_TO_DATE(date , "%D %M")'))->get();
        } elseif ($request->duration == 'year') {
            $properties = Property::select(DB::raw('MONTH(created_at) as num , MONTHNAME(created_at) as date , COUNT(*) as total'))
                ->where(DB::raw('EXTRACT(YEAR FROM created_at)'), '=', DB::raw('EXTRACT(YEAR FROM curdate())'))
                ->groupBy('date', 'num')
                ->orderBy(DB::raw('STR_TO_DATE(date , "%D %M")'))->get();
        }

        if ($request->duration == 'year') {
            foreach ($properties as $prop) {
                array_push(
                    $categories,
                    $prop->date
                );

                array_push($totalValues, $prop->total);
                //$monthName = date("F" , strtotime($prop->created_at));

                $approved = Property::where('publish_status', 'Approved')
                    ->where(DB::raw('EXTRACT(YEAR FROM created_at)'), '=', DB::raw('EXTRACT(YEAR FROM curdate())'))
                    ->where(DB::raw('MONTHNAME(created_at)'),  '=', $prop->date)
                    ->count();
                array_push($totalApproved, $approved);

                $cancel = Property::where('publish_status', 'Cancel')
                    ->where(DB::raw('EXTRACT(YEAR FROM created_at)'), '=', DB::raw('EXTRACT(YEAR FROM curdate())'))
                    ->where(DB::raw('MONTHNAME(created_at)'),  '=', $prop->date)
                    ->count();
                array_push($totalCancel, $cancel);

                $sold = Property::where('is_sold', 1)
                    ->where(DB::raw('EXTRACT(YEAR FROM created_at)'), '=', DB::raw('EXTRACT(YEAR FROM curdate())'))
                    ->where(DB::raw('MONTHNAME(sold_on)'),  '=', $prop->date)
                    ->count();
                array_push($totalSold, $sold);
            }
        } else {
            foreach ($properties as $prop) {
                array_push(
                    $categories,
                    $prop->date
                );

                array_push($totalValues, $prop->total);

                $approved = Property::where('publish_status', 'Approved')
                    ->where(DB::raw('DATE_FORMAT(created_at , "%D %M")'),  '=', $prop->date)
                    ->count();
                array_push($totalApproved, $approved);

                $cancel = Property::where('publish_status', 'Cancel')
                    ->where(DB::raw('DATE_FORMAT(created_at , "%D %M")'), '=', $prop->date)
                    ->count();
                array_push($totalCancel, $cancel);

                $sold = Property::where('is_sold', 1)
                    ->where(DB::raw('DATE_FORMAT(sold_on , "%D %M")'), '=', $prop->date)
                    ->count();
                array_push($totalSold, $sold);
            }
        }

        $new = Property::select(DB::raw('DATE_FORMAT(created_at , "%D %M") as date'), 'city_id' , DB::raw('COUNT(*) as total'))
                        //->where(DB::raw('EXTRACT(YEAR_MONTH FROM created_at)'), '=', DB::raw('EXTRACT(YEAR_MONTH FROM curdate())'))
                        ->groupBy('date' , 'city_id')
                        ->orderBy('date')
                        ->get();

        $series = [];
        $data = [59, 24, 58, 65, 70]; // Update data for 2020 to 2024
        foreach($new as $n) {
            array_push($series , [
                'type' => 'column',
                'name' => $n->city?->name,
                'data' => $data
            ]);
        }
        $data = [
            'categories'    =>  $categories,
            'totalValues'   =>  $totalValues,
            'totalApproved' =>  $totalApproved,
            'totalCancel'   =>  $totalCancel,
            'totalSold'   =>    $totalSold,
            'series'        =>  $series
        ];

        echo json_encode($data);
    }

    public function registrationChart()
    {
        $data = [];

        $sellers = User::where('user_type', 'seller')
            ->select(DB::raw('COUNT(id) as totals'))
            ->groupBy(DB::raw('EXTRACT(YEAR_MONTH FROM created_at)'))
            ->pluck('totals');

        $sellerVerified = User::where('user_type', 'seller')->where('is_otp_verified', '1')
            ->select(DB::raw('COUNT(id) as totals'))
            ->groupBy(DB::raw('EXTRACT(YEAR_MONTH FROM created_at)'))
            ->pluck('totals');

        $agents = User::where('user_type', 'agent')
            ->select(DB::raw('COUNT(id) as totals'))
            ->groupBy(DB::raw('EXTRACT(YEAR_MONTH FROM created_at)'))
            ->pluck('totals');
        $agentVerified = User::where('user_type', 'agent')->where('is_otp_verified', '1')
            ->select(DB::raw('COUNT(id) as totals'))
            ->groupBy(DB::raw('EXTRACT(YEAR_MONTH FROM created_at)'))
            ->pluck('totals');

        $agency = User::where('user_type', 'agency')
            ->select(DB::raw('COUNT(id) as totals'))
            ->groupBy(DB::raw('EXTRACT(YEAR_MONTH FROM created_at)'))
            ->pluck('totals');
        $agencyVerified = User::where('user_type', 'agency')->where('is_otp_verified', '1')
            ->select(DB::raw('COUNT(id) as totals'))
            ->groupBy(DB::raw('EXTRACT(YEAR_MONTH FROM created_at)'))
            ->pluck('totals');

        $dates = User::select(DB::raw('DATE_FORMAT(created_at , "%M %Y") as date'))
            ->distinct()->pluck('date');

        $data = [
            'categories'        =>  $dates,
            'sellerTotal'       =>  $sellers,
            'sellerVerified'    =>  $sellerVerified,
            'agentTotal'        =>  $agents,
            'agentVerified'     =>  $agentVerified,
            'agencyTotal'       =>  $agency,
            'agencyVerified'    =>  $agencyVerified
        ];
        echo json_encode($data);
    }

    public function trafficReport()
    {
        $list = [];

        $users = User::select('user_type', DB::raw('COUNT(id) as totals'))
            ->groupBy('user_type')
            ->get();
        /* $loginHistory = LoginHistory::select('type' , DB::raw('COUNT(*) as totals'))
                    ->groupBy('type')
                    ->get(); */

        if (!empty($users)) {
            foreach ($users as $user) {
                array_push($list, [
                    'name'             =>  $user->user_type,
                    'value'            =>  $user->totals
                ]);
            }
        }

        echo json_encode($list);
    }

    //Function modified by Asim > Now it gives data for "today".
    public function getFilteredData(Request $request)
    {
        $type = $request->input('type'); // 'total', 'approved', 'cancel', or 'sold'
        $duration = $request->input('duration'); // 'today', 'last_month', 'this_year'
        $filterType = $request->input('filterType'); // 'property' or 'ad'

        if($filterType === 'property'){
        $query = Property::query();

        // Filter based on type
        if ($type === 'Approved') {
            $query->where('publish_status', 'Approved');
        } elseif ($type === 'Cancel') {
            $query->where('publish_status', 'Cancel');
        } elseif ($type === 'Sold') {
            $query->where('is_sold', 1);
        }

        // Filter based on duration
        if ($duration === 'today') {
            if ($type === 'Sold') {
                $query->whereDate('sold_on', Carbon::today());
            } else {
                $query->whereDate('created_at', Carbon::today());
            }
        } elseif ($duration === 'last_month') {
            if ($type === 'Sold') {
                $query->whereMonth('sold_on', Carbon::now()->subMonth()->month)
                    ->whereYear('sold_on', Carbon::now()->subMonth()->year);
            } else {
                $query->whereMonth('created_at', Carbon::now()->subMonth()->month)
                    ->whereYear('created_at', Carbon::now()->subMonth()->year);
            }
        } elseif ($duration === 'this_year') {
            if ($type === 'Sold') {
                $query->whereYear('sold_on', Carbon::now()->year);
            } else {
                $query->whereYear('created_at', Carbon::now()->year);
            }
        }
    }
    else if($filterType === 'ad'){
        $query = Ad::query();
        if ($type === 'Approved') {
            $query->where('status', 'approved');
        } elseif ($type === 'Cancel') {
            $query->where('status', 'cancel');
        }
        if ($duration === 'today') {
                $query->whereDate('created_at', Carbon::today());
        } elseif ($duration === 'last_month') {
                $query->whereMonth('created_at', Carbon::now()->subMonth()->month)
                    ->whereYear('created_at', Carbon::now()->subMonth()->year);
        } elseif ($duration === 'this_year') {
                $query->whereYear('created_at', Carbon::now()->year);
        }

    }


        $count = $query->count();

        return response()->json([
            'count' => $count
        ]);
    }
}
