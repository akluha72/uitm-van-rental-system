<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\FormController;
use App\Http\Controllers\LandingPageController;
use App\Http\Controllers\CustomerDashboardController;

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
Route::get('/landingpage', [LandingPageController::class, 'show'])->name('landing');
Route::post('/get-van-details', [FormController::class, 'getVanDetails'])->name('getVanDetails');
Route::post('/get-unavailable-dates', [FormController::class, 'getUnavailableDates'])->name('getUnavailableDates');
Route::get('/get-van-price/{vanId}', [FormController::class, 'getVanPrice'])->name('van.getVanPrice');

Route::get('/payment', [BookingController::class, 'showPayment'])->name('payment');

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

Route::get('/dashboard', [CustomerDashboardController::class, 'index'])->name('dashboard');



require __DIR__ . '/auth.php';
