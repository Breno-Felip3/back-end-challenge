<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

Route::get('/', function(){
    return response()->json(["message" => "Fullstack Challenge 🏅 - Dictionary"]);
});

Route::middleware('api')->group(function(){
    Route::prefix('auth')->group(function () {
        Route::post('/signup', [AuthController::class, 'signup'])->name('register');
        Route::post('/signin', [AuthController::class, 'signin'])->name('login');
        Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:api')->name('logout');
        Route::post('/refresh', [AuthController::class, 'refresh'])->middleware('auth:api')->name('refresh');
        Route::post('/me', [AuthController::class, 'me'])->middleware('auth:api')->name('me');
    });
});


