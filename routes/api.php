<?php


use Illuminate\Support\Facades\Route;


Route::middleware('auth:sanctum')->group(function () {
    Route::get('/available-slots', [AvailabilityController::class, 'getAvailableSlots']);
});
