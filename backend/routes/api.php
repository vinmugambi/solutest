<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TourController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\DestinationController;
use App\Http\Controllers\TicketController;


Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
    return $request->user();
});


Route::middleware('auth:sanctum')->group(function () {
    Route::post('/tours', [TourController::class, 'store']);
    Route::get('/bookings', [BookingController::class, 'index']);
    Route::get('/tickets', [TicketController::class, 'index']);
    Route::post('/destinations', [DestinationController::class, 'store']);
    Route::post('tours/{tour}/book', [BookingController::class, 'store'])->name('book.tour');
    Route::get('bookings/me', [BookingController::class, 'me'])->name('bookings.me');
});

Route::get('/tours', [TourController::class, 'index'])->middleware("guest");
Route::get('/tours/{id}', [TourController::class, 'show'])->middleware("guest");
Route::get('/destinations', [DestinationController::class, 'index'])->middleware("guest");
