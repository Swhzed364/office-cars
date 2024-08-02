<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\car\IndexController;
use App\Http\Controllers\CarController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::controller(AuthController::class)->group(function () {
    Route::post('/register', 'register');
    Route::post('/login', 'login');
});

Route::controller(CarController::class)->prefix('cars')->name('car')->middleware('auth:sanctum')->group(function () {
    Route::get('/vacant', 'findCar')->name('findCars');
});