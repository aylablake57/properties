<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{
    AdController,
    AgentController,
    HomeController,
    ProfileController,
    PropertyController,
    ShopController,
    UserDashboardController,
    MapController,
    NotificationController,
    PackagesController,
    ReviewController,
    UserFeedbackController
};

//for JV partners
Route::redirect('/become-jv-partner', 'https://home.dha360.pk/become-jv-partner/');

// Whastapp integration
Route::get('/whatsapp-chat/{phone}', function ($phone) {
    return redirect()->away('https://wa.me/' . $phone);
})->name('whatsapp.chat');

Route::prefix('/')->group(function () {
    Route::controller(HomeController::class)->group(function () {
        /* Route::get('/' , function() {
            return view('comingsoon.index');
        }); */
        Route::get('/', 'index')->name('home');
        Route::get('search', 'search')->name('search');
        Route::get('trend', 'trend')->name('trend');
        Route::get('welcome', 'welcome')->name('welcome');
        Route::post('getPropertiesByCity', 'propertiesByCities')->name('getPropertiesByCity');
        //Highchart route added by Asim
        Route::get('sendUserlogs', 'sendUserlogs')->name('sendUserlogs');
        Route::get('fetchLatestSearchCount', 'fetchLatestSearchCount')->name('fetchLatestSearchCount');
        Route::get('fetch-trends', 'fetchTrends')->name('fetchTrends'); // By Asfia
        Route::post('filter-fetch-trends', 'filterFetchTrends')->name('filterFetchTrends'); // By Asfia
    });

    Route::get('/locations', [PropertyController::class, 'getCityLocations'])->name('locations');
    Route::get('/subtypes', [PropertyController::class, 'getSubTypes'])->name('subtypes');
    Route::get('/amenities', [PropertyController::class, 'getAmenities'])->name('amenities');
    Route::get('property-details', [PropertyController::class, 'details'])->name('property-details');
    Route::post('send-contact-property', [PropertyController::class, 'contact']);

    Route::prefix('agents')->name('agents.')->group(function () {
        Route::controller(AgentController::class)->group(function () {
            Route::get('list', 'index')->name('list');
            /* Route::get('agency', 'index')->name('agencies');
            Route::get('vendors', 'index')->name('vendors'); */
            Route::post('send-contact-agent', 'contact');
            Route::get('agents-profile/{id}', 'details')->name('agents-profile');
            Route::get('newprofile', 'agentdetails')->name('newprofile'); //new view path added by Yousaf
            Route::post('/submit-feedback', 'submitfeedback')->name('submitfeedback');
        });
    });

    Route::view('about', 'guest.pages.about')->name('about');
    Route::get('maps', [MapController::class, 'index'])->name('maps');
    Route::view('explore', 'guest.pages.explore')->name('explore');
    Route::view('contact', 'guest.pages.contact')->name('contact');
    Route::post('send-contact', [HomeController::class, 'contact']);

    Route::post('/reviews', [ReviewController::class, 'store'])->name('reviews.store');

    Route::get('advertise', [PackagesController::class, 'index'])->name('advertise');

    Route::view('area-unit-converter', 'guest.pages.area-unit-converter')->name('area-unit-converter');

    Route::get('privacy-policy', function () {
        return view('guest.pages.privacy-policy');
    })->name('privacy-policy');

    Route::view('terms-conditions', 'guest.pages.terms')->name('terms-conditions');
});

// For notification
Route::get('notifications/{notification}/mark-as-read', [NotificationController::class, 'markAsRead'])->name('notifications.markAsRead');
Route::get('admin/notifications/{notification}/mark-as-read', [NotificationController::class, 'markAsRead'])->name('notifications.markAsRead');
Route::get('/notifications/clear-all', [NotificationController::class, 'clearAll'])->name('notifications.clearAll');
//for others
Route::middleware(['RevalidateBackHistory', 'auth', 'IsOTPVerified'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::view('/change-password', 'profile.change-password')->name('change.password');
    //Route added for user reviews from seller dashboard modal
    // Route::post('/submit-review', [AgentController::class, 'submitRating'])->name('submitReview');

    //Property Listing Routes
    Route::prefix('property')->name('property.')->group(function () {
        Route::controller(PropertyController::class)->group(function () {
            Route::get('listing', 'index')->name('list');
            Route::get('form/{id?}', 'form')->name('form');
            Route::post('add', 'store')->name('store');
            Route::post('edit', 'store')->name('edit');
            Route::get('remove-image', 'removeImage')->name('remove-image');
            Route::get('sold', 'hasBeenSold')->name('sold');
        });
    });

    //Ads Routes
    Route::prefix('ad')->name('ad.')->group(function () {
        Route::controller(AdController::class)->group(function () {
            Route::get('listing', 'index')->name('list');
            Route::get('form/{id?}', 'form')->name('form');
            Route::post('add', 'store')->name('store');
            Route::post('delete', 'delete')->name('delete');
        });
    });

    //Shop Routes
    Route::prefix('shop')->group(function () {
        Route::controller(ShopController::class)->group(function () {
            Route::get('index', 'index')->name('shop.index');
        });
        Route::get('add-to-cart/{id}', [ShopController::class, 'addToCart']);
        Route::get('cart', [ShopController::class, 'viewCart'])->name('shop.cart');
        Route::patch('update-cart', [ShopController::class, 'updateCart']);
        Route::delete('remove-from-cart', [ShopController::class, 'removeCart']);
    });

    Route::controller(UserDashboardController::class)->group(function () {
        Route::get('dashboard', 'create')->name('dashboard');
        Route::get('prices', 'import')->name('import');
        Route::post('prices', 'import')->name('price.import');
    });

    // Feedback Routes
    Route::get('user-submit-feedback', [UserFeedbackController::class, 'submitFeedback'])->name('submitFeedback'); // By Asfia
    Route::post('user-store-feedback', [UserFeedbackController::class, 'store'])->name('storeFeedback'); // By Asfia
});

require __DIR__ . '/auth.php';
