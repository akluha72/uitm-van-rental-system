<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\FormController;
use App\Http\Controllers\LandingPageController;
use App\Http\Controllers\CustomerDashboardController;

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\VansController;
use App\Http\Controllers\Admin\BookingsController;
use App\Http\Controllers\Admin\CustomersController;
use App\Http\Controllers\Admin\PaymentsController;
use Illuminate\Support\Facades\Mail;

use Illuminate\Support\Facades\Route;

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
Route::get('/', [LandingPageController::class, 'show'])->name('landing');

// Route::get('/landingpage', [LandingPageController::class, 'show'])->name('landing');
Route::post('/get-van-details', [FormController::class, 'getVanDetails'])->name('getVanDetails');
Route::post('/get-unavailable-dates', [FormController::class, 'getUnavailableDates'])->name('getUnavailableDates');
Route::get('/get-van-price/{vanId}', [FormController::class, 'getVanPrice'])->name('van.getVanPrice');
Route::get('/dashboard', [CustomerDashboardController::class, 'index'])->name('dashboard');

Route::get('/payment-fpx', [BookingController::class, 'showPayment'])->name('payment');

Route::middleware('auth')->group(function () {
    Route::get('/booking/{van}', [BookingController::class, 'show'])->name('booking');
    Route::post('/check-availability', [BookingController::class, 'checkAvailability'])->name('checkAvailability');
    Route::post('/submit-booking', [BookingController::class, 'submitBooking'])->name('submitBooking');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::resource('bookings', BookingsController::class)->only(['index', 'show']);
    Route::post('/bookings/{id}/status', [BookingsController::class, 'updateStatus'])->name('bookings.updateStatus');

    // Add Manage Vans Route
    Route::resource('vans', VansController::class);

    //add manage customer route
    Route::resource('customers', CustomersController::class);

    //add manage payment
    Route::get('payments', [PaymentsController::class, 'index'])->name('payments.index');
    Route::get('payments/export-report', [PaymentsController::class, 'export'])->name('payments.export');
    Route::get('payments/{id}', [PaymentsController::class, 'show'])->name('payments.show');
    Route::post('payments/{id}/update', [PaymentsController::class, 'updateStatus'])->name('payments.updateStatus');
   

    Route::get('payments/test', function () {
        return 'Route works!';
    });
    
});

Route::middleware(['guest'])->group(function () {
    Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
    Route::post('/register', [RegisterController::class, 'register'])->middleware('guest');
});




Route::get('/test-email', function () {
    Mail::raw('This is a test email from Van Rental System.', function ($message) {
        $message->to('your_email@example.com') // Replace with your email
                ->subject('Test Email');
    });

    return 'Test email sent!';
});

require __DIR__ . '/auth.php';
