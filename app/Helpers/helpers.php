<?php

use App\Models\{
    Ad,
    Amenity,
    Property,
    User,
    UserSearchLog
};
use App\Notifications\{
    ApprovalNotification,
    AdApprovedNotification,
    AdminApprovalNotification,
    CancellationNotification
};
use Illuminate\Support\Facades\{
    Auth,
    Cookie,
    DB,
    Notification
};
use Carbon\Carbon;


function getAdminAsset($str)
{
    return url('assets/' . $str);
}

function toCurrency($value, $currency, $fractionDigits = 0)
{
    $acceptedCurencies = ["PKR" => "en_pak", "USD" => "en_US", "VND" => "vi_VN"];

    if (!in_array($currency, array_keys($acceptedCurencies)))
        return $value;

    if (!is_numeric($value))
        return $value;

    $formatter = new NumberFormatter($acceptedCurencies[$currency], NumberFormatter::CURRENCY);
    $formatter->setAttribute(NumberFormatter::FRACTION_DIGITS, $fractionDigits);
    $formattedNumber = $formatter->format($value);

    return $formattedNumber;
}

/* function getCityPercentages()
{
    $totalCount = UserSearchLog::count();
    $cityCounts = UserSearchLog::select('search_query', DB::raw('count(*) as count'))
                                ->whereBetween('created_at', [Carbon::now()->startOfMonth(), Carbon::now()->endOfMonth()])
                                ->groupBy('search_query')
                                ->get();
    $cityPercentages = $cityCounts->map(function ($city) use ($totalCount) {
        $city->percentage = ($city->count / $totalCount) * 100;
        return $city;
    });

    if ($cityPercentages) {
        $cityPercentages = $cityPercentages->sortByDesc('count');
    }

    return $cityPercentages;
} */

function getPieChartData()
{
    $searchData = UserSearchLog::select('search_query')
        ->whereNotNull('search_query') // Excludes NULL entries
        ->groupBy('search_query')
        ->selectRaw('count(*) as count')
        ->get();

    // Prepare data for Highcharts (Pie Chart)
    $locationWiseData = [];
    foreach ($searchData as $data) {
        $locationWiseData[] = ['name' => $data->search_query, 'y' => (int) $data->count];
    }
    // dd($locationWiseData);
    return $locationWiseData;
}

function getSplineChartData()
{
    // Prepare data for Spline Chart (e.g., hourly counts)
    $searchCountsByHour = UserSearchLog::select(
        DB::raw('DATE(created_at) as date'),
        DB::raw('HOUR(created_at) as hour'),
        DB::raw('count(*) as count')
    )
        ->whereBetween('created_at', [Carbon::now()->startOfMonth(), Carbon::now()->endOfMonth()])
        ->groupBy('date', 'hour')
        ->orderBy('date')
        ->orderBy('hour')
        ->get();

    $splineData = [];
    foreach ($searchCountsByHour as $data) {
        $timestamp = Carbon::createFromFormat('Y-m-d H', $data->date . ' ' . $data->hour)->timestamp * 1000; // convert to milliseconds
        $splineData[] = [$timestamp, (int) $data->count];
    }

    return $splineData;
}

function fetchLatestSearchCount()
{
    // Get the latest search count for the current time period (e.g., last hour)
    $latestCount = UserSearchLog::where('created_at', '>=', now()->subHour())
        ->count();

    return response()->json([
        'searchCount' => $latestCount,
    ]);
}

function showUserImage($user)
{
    $path = '';
    if ($user) {
        $path = $user->profile_image ? env('FTP_BASE_URL') . '/' . $user->profile_image : 'assets/images/users/blank.png';
    }

    return asset($path);
}

function showPropertyImage($property)
{
    $path = $property->featured_image
        ? env('FTP_BASE_URL') . '/' . $property->featured_image
        : asset('assets/images/no-image-found.png');

    return $path;
}

function getLatestProperties()
{
    return Property::where('publish_status', 'Approved')->where('is_sold', 0)->take(3)->latest()->get();
}

function getAmenities()
{
    $amenities = Amenity::all();
    $amenitiesArray = [];
    foreach ($amenities as $key => $amenity) {
        $amenitiesArray[$amenity->key][$key]['id'] = $amenity->id;
        $amenitiesArray[$amenity->key][$key]['value'] = $amenity->value;
    }
    return $amenitiesArray;
}

function getAdsForColumn()
{
    return Ad::where('is_approved', 1)->orderByRaw('RAND()')->get();
}

function SmsCellPhoneNumber($phonenumber)
{
    $phonenumber = CellPhoneNumber($phonenumber);
    return $phonenumber;
}

function CellPhoneNumber($phonenumber)
{
    $phonenumber        =   str_replace("(", "", $phonenumber);
    $phonenumber        =   str_replace(")", "", $phonenumber);
    $phonenumber        =   str_replace(array(" ", '"'), "", $phonenumber);
    $phonenumber        =   str_replace(array("-", '"'), "", $phonenumber);
    $phonenumber        =   str_replace("+", "", $phonenumber);
    if (substr($phonenumber, 0, 2) != "92") {
        $phonenumber        =   '92' . $phonenumber;
    }

    $phonenumber92      =   0;
    $phonenumber0       =   0;
    if (substr($phonenumber, 0, 3) == "092") {
        $phn = substr($phonenumber, 3);
        $phonenumber92   = "923" . $phn;
        $phonenumber0    = "03" . $phn;
    } elseif (substr($phonenumber, 0, 3) == "+92") {
        $phn = substr($phonenumber, 3);
        $phonenumber92   = "923" . $phn;
        $phonenumber0    = "03" . $phn;
    } elseif (substr($phonenumber, 0, 2) == "92") {
        $phn = substr($phonenumber, 3);
        $phonenumber92   = "923" . $phn;
        $phonenumber0    = "03" . $phn;
    } elseif (substr($phonenumber, 0, 2) == "03") {
        $phn = substr($phonenumber, 2);
        $phonenumber92   = "923" . $phn;
        $phonenumber0    = "03" . $phn;
    }

    if (substr($phonenumber, 0, 3) == '920') {
        $phn = substr($phonenumber, 3);
        $phonenumber92 = '92' . $phn;
        $phonenumber0 = '0' . $phn;
    }

    if (strlen($phonenumber92) == 12) {
        return $phonenumber92;
    } else {
        return $phonenumber;
    }
}

function isPropertySeen($propertyId)
{
    $seen_properties = unserialize(Cookie::get('seen_properties', serialize([])));
    return in_array($propertyId, $seen_properties);
}

function markPropertyAsSeen($propertyId)
{
    $seen_properties = unserialize(Cookie::get('seen_properties', serialize([])));

    if (!in_array($propertyId, $seen_properties)) {
        $seen_properties[] = $propertyId;
        Cookie::queue('seen_properties', serialize($seen_properties), 60 * 24 * 30);
    }
}

function getNotifications()
{
    $notifications = Auth::user()->unreadNotifications ?? collect();

    return $notifications;
}

function notifySuperadminAboutNewApprovalNotification($ad = null, $property = null)
{

    $superadmin = User::role('superadmin')->first();

    if ($superadmin) {
        Notification::send($superadmin, new AdminApprovalNotification($ad, $property));
    }
}

function notifyUserAboutApproval($ad = null, $property = null)
{
    if ($ad) {
        Notification::send($ad->user, new ApprovalNotification($ad));
    } elseif ($property) {
        Notification::send($property->user, new ApprovalNotification(null, $property));
    }
}
function notifyUserAboutCancel($ad = null, $property = null)
{
    if ($ad) {
        Notification::send($ad->user, new CancellationNotification($ad));
    } elseif ($property) {
        Notification::send($property->user, new CancellationNotification(null, $property));
    }
}


function getEmbedUrl($url)
{
    // YouTube
    if (preg_match('/^(https?:\/\/)?(www\.)?(youtube\.com|youtu\.?be)\/.+$/', $url)) {
        $regExp = '/^.*(youtu.be\/|v\/|u\/\w\/|embed\/|watch\?v=|&v=)([^#&?]*).*/';
        preg_match($regExp, $url, $match);
        return isset($match[2]) && strlen($match[2]) === 11 ? 'https://www.youtube.com/embed/' . $match[2] : null;
    }
    // TikTok
    elseif (preg_match('/^(https?:\/\/)?(www\.)?tiktok\.com\/.+$/', $url)) {
        return preg_replace('/(https?:\/\/)?(www\.)?tiktok\.com\/(.+)/', 'https://www.tiktok.com/embed/$3', $url);
    }
    // Facebook
    elseif (preg_match('/^(https?:\/\/)?(www\.)?facebook\.com\/.+$/', $url)) {
        return preg_replace('/(https?:\/\/)?(www\.)?facebook\.com\/(.+)/', 'https://www.facebook.com/plugins/video.php?href=https://www.facebook.com/$3', $url);
    }

    return null;
}


function getCountsAds()
{
    $total = Ad::all()->count();
    $totalMonth = Ad::where(DB::raw('EXTRACT(YEAR_MONTH FROM created_at)'), '=', DB::raw('EXTRACT(YEAR_MONTH FROM curdate())'))
        ->count();
    $totalYear = Ad::whereYear('created_at', now()->year)->count();
    $previousMonth = Carbon::now()->subMonth();
    $totalPreviousMonth = Ad::whereYear('created_at', $previousMonth->year)
        ->whereMonth('created_at', $previousMonth->month)
        ->count();

    $approved = Ad::where('status', 'approved')->count();
    $approvedMonth = Ad::where('status', 'approved')
        ->where(DB::raw('EXTRACT(YEAR_MONTH FROM created_at)'), '=', DB::raw('EXTRACT(YEAR_MONTH FROM curdate())'))
        ->count();
    $approvedLastMonth = Carbon::now()->subMonth();
    $approvedPreviousMonth = Ad::where('status', 'approved')->whereYear('created_at', $approvedLastMonth->year)
        ->whereMonth('created_at', $approvedLastMonth->month)
        ->count();
    $approvedYear = Ad::where('status', 'approved')->whereYear('created_at', now()->year)->count();
    $cancel = Ad::where('status', 'cancel')->count();
    $cancelMonth = Ad::where('status', 'cancel')
        ->where(DB::raw('EXTRACT(YEAR_MONTH FROM created_at)'), '=', DB::raw('EXTRACT(YEAR_MONTH FROM curdate())'))
        ->count();
    $cancelLastMonth = Carbon::now()->subMonth();
    $cancelPreviousMonth = Ad::where('status', 'cancel')->whereYear('created_at', $cancelLastMonth->year)
        ->whereMonth('created_at', $cancelLastMonth->month)
        ->count();
    $cancelYear = Ad::where('status', 'cancel')->whereYear('created_at', now()->year)->count();
    // add expiry_date ads count
    $expiredAds = Ad::where('expiry_date', '<', now())->count();
    $expiredAdsMonth = Ad::where('expiry_date', '<', now())
        ->where(DB::raw('EXTRACT(YEAR_MONTH FROM expiry_date)'), '=', DB::raw('EXTRACT(YEAR_MONTH FROM curdate())'))
        ->count();
    $expiredAdsPreviousMonth = Carbon::now()->subMonth();
    $expiredAdsPreviousMonth = Ad::where('expiry_date', '<', $expiredAdsPreviousMonth)
        ->whereYear('expiry_date', $expiredAdsPreviousMonth->year)
        ->whereMonth('expiry_date', $expiredAdsPreviousMonth->month)
        ->count();
    $expiredAdsYear = Ad::where('expiry_date', '<', now())
        ->whereYear('expiry_date', now()->year)
        ->count();

    return [
        'total' => $total,
        'totalMonth' => $totalMonth,
        'totalPreviousMonth' => $totalPreviousMonth,
        'totalYear' => $totalYear,
        'approved' => $approved,
        'approvedMonth' => $approvedMonth,
        'approvedPreviousMonth' => $approvedPreviousMonth,
        'approvedYear' => $approvedYear,
        'cancel' => $cancel,
        'cancelMonth' => $cancelMonth,
        'cancelPreviousMonth' => $cancelPreviousMonth,
        'cancelYear' => $cancelYear,
        'expiredAds' => $expiredAds,
        'expiredAdsMonth' => $expiredAdsMonth,
        'expiredAdsPreviousMonth' => $expiredAdsPreviousMonth,
        'expiredAdsYear' => $expiredAdsYear,
    ];
}

function formatPhoneNumber($number)
{
    // Remove any non-digit characters
    $number = preg_replace('/\D+/', '', $number);

    // Check if it's a valid Pakistani number starting with 92
    if (preg_match('/^92(\d{3})(\d{7})$/', $number, $matches)) {
        return "+92 {$matches[1]} {$matches[2]}";
    }

    // Fallback
    return $number;
}
