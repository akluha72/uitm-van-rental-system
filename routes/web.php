<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\FormController;
use App\Http\Controllers\LandingPageController;
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

//todo make sure the data submitted to the database properly
//fix for the form submission use ajax method. not the blade method

Route::get('/landingpage', [LandingPageController::class, 'show'])->name('landing');
Route::post('/get-van-details', [FormController::class, 'getVanDetails'])->name('getVanDetails');
Route::post('/get-unavailable-dates', [FormController::class, 'getUnavailableDates'])->name('getUnavailableDates');


Route::middleware('auth')->group(function () {
    Route::get('/booking/{van}', [BookingController::class, 'show'])->name('booking');
    Route::post('/check-availability', [BookingController::class, 'checkAvailability'])->name('checkAvailability');
    Route::post('/submit-booking', [BookingController::class, 'submitBooking'])->name('submitBooking');
});



Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
