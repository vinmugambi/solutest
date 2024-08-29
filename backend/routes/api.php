<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TourController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\TicketController;


Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
    return $request->user();
});


Route::middleware('auth:sanctum')->group(function () {
    Route::post('/tours', [TourController::class, 'store']);
    Route::get('/bookings', [BookingController::class, 'index']);
    Route::get('/tickets', [TicketController::class, 'index']);
});

Route::middleware(['auth:sanctum'])->group(function () {
    Route::post('tours/{tour}/bookings', [BookingController::class, 'store'])->name('book.tour');
    Route::post('bookings/{booking}/tickets', [TicketController::class, 'store'])->name('ticket.booking');
});
