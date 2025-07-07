<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FeedbackController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\BookingPhotoController;
use App\Http\Controllers\StripeController;
use Illuminate\Support\Facades\File;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\Admin\ServiceController;
use App\Http\Controllers\ClientServiceController;
use App\Http\Controllers\AdminPortfolioController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Admin\BookingController as AdminBookingController;




/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

//CLIENT PAGE
//Dashboard//


Route::get('/', function () {
    return view('welcome');
});

Route::post('/admin/bookings/complete/{id}', [AdminController::class, 'markAsCompleted'])->name('admin.bookings.complete');

Route::view('/about', 'client.about')->name('about');
Route::view('/faq', 'client.faq')->name('faq');
Route::view('/feedback', 'client.feedback')->name('feedback');
Route::view('/contact', 'client.contact')->name('contact');


//Register//

Route::get('/register', [RegisteredUserController::class, 'create'])->middleware('guest')->name('register');

Route::post('/register', [RegisteredUserController::class, 'store'])->middleware('guest');

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard/loyalty', [DashboardController::class, 'viewLoyaltyPoints'])->name('dashboard.loyalty');
    Route::post('/admin/loyalty/edit/{userID}', [DashboardController::class, 'editLoyaltyPoints'])->name('admin.loyalty.edit');
});

Route::get('/mybookings', function () {
    return view('mybookings');
})->name('mybookings');

// -> Feedback section
Route::post('/feedback', [FeedbackController::class, 'store'])->name('feedback.store');

Route::get('/dashboard', [FeedbackController::class, 'index'])->name('dashboard');

//Profile

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});



Route::get('/services/bridal', [ClientServiceController::class, 'showBridal'])->name('bridal.details');


Route::get('/services/makeup', [ClientServiceController::class, 'showMakeup'])->name('makeup.details');
Route::get('/services/hairdo', [ClientServiceController::class, 'showHairdo'])->name('hairdo.details');
Route::get('/services/saree', [ClientServiceController::class, 'showSaree'])->name('saree.details');
Route::get('/services/makeover', [ClientServiceController::class, 'showMakeover'])->name('makeover.details');
Route::get('/henna', [ClientServiceController::class, 'showHenna'])->name('services.henna');
Route::get('/henna/details', [ClientServiceController::class, 'showIndividualHenna'])->name('henna.details');
Route::get('/services/henna/group', [ClientServiceController::class, 'showGroupHenna'])->name('henna.group');
Route::get('/services/henna/individual', [ClientServiceController::class, 'showIndividualHenna'])->name('henna.individual');

//Booking Page
Route::middleware(['auth'])->group(function () {
    Route::get('/booking/view', [BookingController::class, 'view'])->name('booking.view');
    Route::post('/booking/add', [BookingController::class, 'add'])->name('booking.add');
    Route::post('/photo-upload', [BookingController::class, 'uploadPhoto'])->name('photo.upload');
    Route::delete('/booking/remove/{id}', [BookingController::class, 'remove'])->name('booking.remove');
    Route::delete('/booking/clear', [BookingController::class, 'clear'])->name('booking.clear');
});


Route::put('/booking/update/{id}', [BookingController::class, 'updateQuantity'])->name('booking.updateQuantity');

Route::post('/photo/upload', [BookingPhotoController::class, 'upload'])->name('photo.upload');

Route::delete('/photo/{id}/delete', [BookingPhotoController::class, 'destroy'])->name('photo.delete');

Route::get('/catalog', function () {
    return view('catalog'); // or your actual view/controller
})->name('catalog.view');

//Address Page
Route::get('/next', function () {
    return view('address', [
        'serviceName' => session('serviceName'),
        'selectedDate' => session('selectedDate'),
        'selectedTime' => session('selectedTime'),
        'price' => session('price'),
    ]);
})->name('next.page');

Route::post('/confirm-booking', [BookingController::class, 'confirm'])->name('booking.confirm');


Route::post('/booking/{id}/comment', [BookingController::class, 'updateComment'])->name('booking.comment');

Route::get('/api/blocked-slots', [BookingController::class, 'getBlockedSlots']);






//Summary Page
Route::post('/booking/confirm', [BookingController::class, 'confirm'])->name('booking.confirm');

Route::get('/booking/summary', [BookingController::class, 'summary'])->name('booking.summary');

Route::get('/summary', [BookingController::class, 'summary'])->name('summary');


Route::get('/schedule', function () {
    return view('address'); 
})->name('schedule');



//Payment Page

Route::get('/checkout', [StripeController::class, 'showForm'])->name('checkout.form');
Route::post('/stripe/checkout', [StripeController::class, 'createCheckoutSession'])->name('stripe.checkout');
Route::get('/payment/success', [StripeController::class, 'success'])->name('checkout.success');
Route::get('/payment/cancel', [StripeController::class, 'cancel'])->name('checkout.cancel');



//Past-Bookings
Route::get('/my-bookings', [BookingController::class, 'showBookingHistory']);
Route::get('/my-bookings', [BookingController::class, 'showBookingHistory'])->name('my_bookings');
Route::post('/booking/cancel-group', [BookingController::class, 'cancelGroup'])->name('booking.cancel.group');



//Portfolio
// Main Portfolio Page
Route::get('/portfolio', function () {
    return view('portfolio.index');
})->name('portfolio');

// Portfolio detail page with category and artist
// HAND HENNA
use App\Models\HandHenna;

Route::get('/portfolio/handhenna', function () {
    if (Auth::check() && Auth::user()->hasRole('admin')) {
        return redirect()->route('admin.portfolio.a_handhenna');
    }

    $images = HandHenna::all(); // ✅ Pull from DB
    return view('portfolio.handhenna', compact('images'));
})->name('portfolio.handhenna');


// LEG HENNA
use App\Models\LegHenna;

Route::get('/portfolio/leghenna', function () {
    if (Auth::check() && Auth::user()->hasRole('admin')) {
        return redirect()->route('admin.portfolio.a_leghenna');
    }

    $images = LegHenna::all(); // ✅ pulling from DB
    return view('portfolio.leghenna', compact('images'));
})->name('portfolio.leghenna');

// BRIDAL HENNA
use App\Models\BridalHenna;

Route::get('/portfolio/bridalhenna', function () {
    if (Auth::check() && Auth::user()->hasRole('admin')) {
        return redirect()->route('admin.portfolio.a_bridalhenna');
    }

    $images = BridalHenna::all(); // ✅ pulls from DB like others
    return view('portfolio.bridalhenna', compact('images'));
})->name('portfolio.bridalhenna');



// BUN HAIRSTYLE
use App\Models\BunHairstyle;

Route::get('/portfolio/bunhairstyle', function () {
    if (Auth::check() && Auth::user()->hasRole('admin')) {
        return redirect()->route('admin.portfolio.a_bunhairstyle');
    }

    $images = BunHairstyle::all(); // ✅ fetch from DB
    return view('portfolio.bunhairstyle', compact('images'));
})->name('portfolio.bunhairstyle');
// BRAID HAIRSTYLE
use App\Models\BraidHairstyle;

Route::get('/portfolio/braidhairstyle', function () {
    if (Auth::check() && Auth::user()->hasRole('admin')) {
        return redirect()->route('admin.braid');
    }

    $images = BraidHairstyle::all(); // ✅ Pull from new model
    return view('portfolio.braidhairstyle', compact('images'));
})->name('portfolio.braidhairstyle');



// HALF-UP HAIRSTYLE
use App\Models\HalfUpHairstyle;

Route::get('/portfolio/halfuphairstyle', function () {
    if (Auth::check() && Auth::user()->hasRole('admin')) {
        return redirect()->route('admin.portfolio.a_halfuphairstyle');
    }

    $images = HalfUpHairstyle::all(); // ✅ pulling from DB
    return view('portfolio.halfuphairstyle', compact('images')); // ✅ this should match filename
})->name('portfolio.halfuphairstyle');

Route::get('/portfolio/chinesemakeup', function () {
    if (Auth::check() && Auth::user()->hasRole('admin')) {
        return redirect()->route('admin.portfolio.a_chinesemakeup');
    }

    $images = \App\Models\ChineseMakeup::all();

    return view('portfolio.chinesemakeup', compact('images'));
})->name('portfolio.chinesemakeup');


use App\Models\IndianMakeup;

Route::get('/portfolio/indianmakeup', function () {
    if (Auth::check() && Auth::user()->hasRole('admin')) {
        return redirect()->route('admin.portfolio.a_indianmakeup');
    }

    $images = IndianMakeup::all(); // ✅ Fetch from DB
    return view('portfolio.indianmakeup', compact('images'));
})->name('portfolio.indianmakeup');


// CLIENT view — only if NOT admin
Route::get('/portfolio/bridalmakeup', function () {
    if (Auth::check() && Auth::user()->hasRole('admin')) {
        return redirect()->route('admin.portfolio.a_bridalmakeup');
    }

    $images = collect(File::files(public_path("images/portfolio/bridalmakeup")))
        ->filter(fn($file) => in_array($file->getExtension(), ['jpg', 'jpeg', 'png']))
        ->map(fn($file) => asset("images/portfolio/bridalmakeup/" . $file->getFilename()));

    return view('portfolio.bridalmakeup', compact('images'));
})->name('portfolio.bridalmakeup');



//ADMIN PAGE

//Role Based
Route::middleware(['auth', 'role:admin'])->group(function () {
    // Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
});

Route::middleware(['auth', 'role:admin'])->group(function () {
    // Add more admin-only routes here
});

//Services Page
Route::middleware(['auth', 'role:admin'])->group(function () {});

Route::get('/admin/dashboard', [AdminController::class, 'showDashboard'])->name('admin.dashboard');

Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::resource('services', ServiceController::class);
    Route::get('/dashboard', [AdminController::class, 'showDashboard'])->name('dashboard');
});

Route::get('/admin/services', [AdminController::class, 'services'])->name('admin.services.index');

//Analytics Page
Route::get('/admin/analytics', [AdminController::class, 'analytics'])->name('admin.analytics');
Route::get('/admin/analytics/report', [AdminController::class, 'generateReport'])->name('admin.analytics.report');



//Past-Bookings
Route::get('/admin/upcoming-bookings', [AdminController::class, 'viewAllUpcomingBookings'])
    ->middleware(['auth', 'role:admin']) // optional role check
    ->name('admin.bookings.upcoming');

Route::get('/admin/bookings', [AdminController::class, 'viewAllBookings'])->name('admin.bookings.upcoming');
Route::post('/admin/bookings/mark-completed/{id}', [AdminController::class, 'markCompleted'])->name('admin.bookings.complete');

Route::post('/booking/cancel-group', [BookingController::class, 'cancelGroup'])->name('booking.cancel.group');

//Portfolio
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::resource('portfolio', AdminPortfolioController::class)->except(['show']);
});

// Braid page
Route::get('/admin/portfolio/braid-hairstyle', [AdminPortfolioController::class, 'a_braidHairstyle'])->name('admin.braid');
Route::post('/admin/portfolio/braid-hairstyle/update/{id}', [AdminPortfolioController::class, 'updateBraidHairstyle'])->name('admin.braid.update');
Route::delete('/admin/portfolio/braid-hairstyle/delete/{id}', [AdminPortfolioController::class, 'destroyBraidHairstyle'])->name('admin.braid.delete');
Route::post('/admin/portfolio/braid-hairstyle/upload', [AdminPortfolioController::class, 'uploadBraidHairstyle'])->name('admin.braid.upload');

// Bridal Henna page
Route::get('/admin/portfolio/a_bridalhenna', [AdminPortfolioController::class, 'a_bridalHenna'])->name('admin.portfolio.a_bridalhenna');

// Update bridal henna image
Route::post('/admin/bridalhenna/update/{id}', [AdminPortfolioController::class, 'updateBridalHenna'])->name('admin.bridalhenna.update');

Route::delete('/admin/portfolio/delete/{id}', [AdminPortfolioController::class, 'destroy'])->name('admin.portfolio.delete');
Route::delete('/admin/bridalhenna/delete/{id}', [AdminPortfolioController::class, 'destroyBridalHenna'])->name('admin.bridalhenna.delete');
Route::post('/admin/bridalhenna/upload', [AdminPortfolioController::class, 'uploadBridalHenna'])->name('admin.bridalhenna.upload');

//Bridal Makeup
Route::get('/admin/portfolio/a_bridalmakeup', [AdminPortfolioController::class, 'a_bridalMakeup'])->name('admin.portfolio.a_bridalmakeup');
Route::post('/admin/bridalmakeup/update/{id}', [AdminPortfolioController::class, 'updateBridalMakeup'])->name('admin.bridalmakeup.update');
Route::delete('/admin/bridalmakeup/delete/{id}', [AdminPortfolioController::class, 'destroyBridalMakeup'])->name('admin.bridalmakeup.delete');

Route::post('/admin/bridalmakeup/upload', [AdminPortfolioController::class, 'uploadBridalMakeup'])->name('admin.bridalmakeup.upload');

//Bun Hairstyle
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/admin/portfolio/a_bunhairstyle', [AdminPortfolioController::class, 'a_bunHairstyle'])->name('admin.portfolio.a_bunhairstyle');

Route::post('/admin/bunhairstyle/update/{id}', [AdminPortfolioController::class, 'updateBunHairstyle'])->name('admin.bunhairstyle.update');

Route::delete('/admin/bunhairstyle/delete/{id}', [AdminPortfolioController::class, 'destroyBunHairstyle'])->name('admin.bunhairstyle.delete');

Route::post('/admin/bunhairstyle/upload', [AdminPortfolioController::class, 'uploadBunHairstyle'])->name('admin.bunhairstyle.upload');

});

//Chinese Makeup
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/admin/portfolio/a_chinesemakeup', [AdminPortfolioController::class, 'a_chineseMakeup'])->name('admin.portfolio.a_chinesemakeup');
    Route::post('/admin/chinesemakeup/update/{id}', [AdminPortfolioController::class, 'updateChineseMakeup'])->name('admin.chinesemakeup.update');
    Route::delete('/admin/chinesemakeup/delete/{id}', [AdminPortfolioController::class, 'destroyChineseMakeup'])->name('admin.chinesemakeup.delete');
Route::post('/admin/chinesemakeup/upload', [AdminPortfolioController::class, 'uploadChineseMakeup'])->name('admin.chinesemakeup.upload');

});

//Half Up Hairstyle
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/admin/portfolio/a_halfuphairstyle', [AdminPortfolioController::class, 'a_halfUpHairstyle'])->name('admin.portfolio.a_halfuphairstyle');
    Route::post('/admin/halfuphairstyle/update/{id}', [AdminPortfolioController::class, 'updateHalfUpHairstyle'])->name('admin.halfuphairstyle.update');
    Route::delete('/admin/halfuphairstyle/delete/{id}', [AdminPortfolioController::class, 'destroyHalfUpHairstyle'])->name('admin.halfuphairstyle.delete');
Route::post('/admin/halfuphairstyle/upload', [AdminPortfolioController::class, 'uploadHalfUpHairstyle'])->name('admin.halfuphairstyle.upload');
 
});

//Hand henna

Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/admin/portfolio/a_handhenna', [AdminPortfolioController::class, 'a_handHenna'])->name('admin.portfolio.a_handhenna');
    Route::post('/admin/handhenna/update/{id}', [AdminPortfolioController::class, 'updateHandHenna'])->name('admin.handhenna.update');
    Route::delete('/admin/handhenna/delete/{id}', [AdminPortfolioController::class, 'destroyHandHenna'])->name('admin.handhenna.delete');
    Route::post('/admin/handhenna/upload', [AdminPortfolioController::class, 'uploadHandHenna'])->name('admin.handhenna.upload');

});

//Indian Makeup

Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/admin/portfolio/a_indianmakeup', [AdminPortfolioController::class, 'a_indianMakeup'])->name('admin.portfolio.a_indianmakeup');
    Route::post('/admin/indianmakeup/update/{id}', [AdminPortfolioController::class, 'updateIndianMakeup'])->name('admin.indianmakeup.update');
    Route::delete('/admin/indianmakeup/delete/{id}', [AdminPortfolioController::class, 'destroyIndianMakeup'])->name('admin.indianmakeup.delete');
Route::post('/admin/indianmakeup/upload', [AdminPortfolioController::class, 'uploadIndianMakeup'])->name('admin.indianmakeup.upload');

});

//Leg Henna

Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/admin/portfolio/a_leghenna', [AdminPortfolioController::class, 'a_legHenna'])->name('admin.portfolio.a_leghenna');
    Route::post('/admin/leghenna/update/{id}', [AdminPortfolioController::class, 'updateLegHenna'])->name('admin.leghenna.update');
    Route::delete('/admin/leghenna/delete/{id}', [AdminPortfolioController::class, 'destroyLegHenna'])->name('admin.leghenna.delete');
Route::post('/admin/leghenna/upload', [AdminPortfolioController::class, 'uploadLegHenna'])->name('admin.leghenna.upload');

});

//Admin client page
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/admin/clients', [AdminController::class, 'showClients'])->name('admin.clients');
    Route::post('/admin/clients/{id}/update-points', [AdminController::class, 'updatePoints'])->name('admin.clients.updatePoints');
});

//Admin Add Booking Page
Route::prefix('admin')->middleware(['auth', 'role:admin'])->group(function () {
    Route::get('bookings/create', [AdminBookingController::class, 'create'])->name('admin.bookings.create');
    Route::post('bookings', [AdminBookingController::class, 'store'])->name('admin.bookings.store');
});
Route::get('/admin/bookings/create', [AdminController::class, 'createBooking'])->name('admin.bookings.create');

//Redeem Reward Client
Route::post('/redeem-reward', [BookingController::class, 'redeemReward'])->name('redeem.reward');
Route::get('/booking', [BookingController::class, 'view'])->name('booking.view');




require __DIR__.'/auth.php';

