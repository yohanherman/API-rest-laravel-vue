<?php

use App\Http\Controllers\V1\bookingController;
use App\Http\Controllers\V1\PlaceController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::prefix('/v1')->group(function () {
    Route::get('/place', [PlaceController::class, 'index']);
    Route::get('/place/{id}', [PlaceController::class, 'show']);
    Route::delete('/place/{id}', [PlaceController::class, 'destroy']);
    Route::put('/place/{id}', [PlaceController::class, 'update']);
    Route::post('/store', [PlaceController::class, 'store']);

    Route::post('/book', [bookingController::class, 'book']);
    Route::get('/book', [bookingController::class, 'index']);
});
