<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return [
        'massege' => 'Use api please'
    ];
});

Route::get('/login', function () {
    return [
        'status' => false,
        'massege' => 'Authentication required'
    ];
})->name('login');