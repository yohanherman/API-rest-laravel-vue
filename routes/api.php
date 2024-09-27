<?php

use App\Http\Controllers\V1\pdfController;
use App\Http\Controllers\V1\AuthController;
use App\Http\Controllers\V1\bookingController;
use App\Http\Controllers\V1\PlaceController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::prefix('/v1')->group(function () {

    Route::get('/downloadpdf/{id}', [pdfController::class, 'downloadPdf']);

    // non required authentication routes
    Route::get('/place', [PlaceController::class, 'index'])->name('get.place');
    Route::post('/register', [AuthController::class, 'registerPost'])->name('get.register');
    Route::post('/login', [AuthController::class, 'loginPost'])->name('post.login');
    // Route::get('/login', [AuthController::class, 'login'])->name('get.login');
    // 


    // route a proteger par le middleware admin
    Route::get('/place/{id}', [PlaceController::class, 'show']);
    Route::put('/place/{id}', [PlaceController::class, 'update'])->name('update.place')->where('id', '[0-9]+');
    Route::post('/store', [PlaceController::class, 'store']);
    Route::delete('/place/{id}', [PlaceController::class, 'destroy'])->name('destroy.place')->where('id', '[0-9]+');
    Route::post('/book', [bookingController::class, 'book']);
    // Route::get('/boo', [bookingController::class, 'index']);
    // 


    // Authenticated routes for normal users
    Route::middleware('auth:api')->group(function () {
        Route::get('/logout', [AuthController::class, 'logout']);
        Route::get('/booking-show', [bookingController::class, 'userReservation'])->name('get.userBooking');
        Route::put('/booking-cancel/{id}', [bookingController::class, 'cancelBooking'])->where('id', '[0-9]+');
        Route::post('/booking-store', [bookingController::class, 'addBooking']);
        // Route::get('/downloadpdf', [pdfController::class, 'downloadPdf']);
    });
});



// Route::get('/email/verify', [AuthController::class, 'verificationMail'])->middleware('auth')->name('verification.notice');
// Route::get('/email/verify/{id}/{hash}', [AuthController::class, 'procedeMail'])->middleware(['auth', 'signed'])->name('verification.verify');
