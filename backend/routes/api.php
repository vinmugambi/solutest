<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TourController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\DestinationController;
use App\Http\Controllers\TicketController;

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    Route::post('/tours', [TourController::class, 'store']);
    Route::get('/tickets', [TicketController::class, 'index']);
    Route::post('/destinations', [DestinationController::class, 'store']);
    Route::post('tours/{tour}/book', [BookingController::class, 'store'])->name('tour.book');
    Route::get('bookings/me', [BookingController::class, 'me'])->name('bookings.me');
    Route::post('/bookings/{booking}/confirm', [BookingController::class, 'confirm'])
        ->name('bookings.confirm');
    Route::get('/bookings', [BookingController::class, 'index']);
    Route::get('/bookings/{id}', [BookingController::class, 'show']);
});

Route::middleware('guest')->group(function () {
    Route::get('/tours', [TourController::class, 'index']);
    Route::get('/tours/{id}', [TourController::class, 'show']);
    Route::get('/destinations', [DestinationController::class, 'index']);
});
