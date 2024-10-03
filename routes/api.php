<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\FileController;
use App\Http\Controllers\WordController;
use Illuminate\Support\Facades\Route;

Route::get('/', function(){
    return response()->json(["message" => "Fullstack Challenge 🏅 - Dictionary"]);
});

Route::post('/auth/signup', [AuthController::class, 'signup'])->name('register');
Route::post('/auth/signin', [AuthController::class, 'signin'])->name('login');

Route::middleware('auth:api')->group(function(){
    Route::prefix('auth')->group(function () {
        Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
        Route::post('/refresh', [AuthController::class, 'refresh'])->name('refresh');
        Route::get('/me', [AuthController::class, 'me'])->name('me');
    });

    Route::post('/upload-txt', [FileController::class, 'uploadTxt']);

    Route::prefix('entries')->group(function(){
        Route::get('/en', [WordController::class, 'index']);
    });
});


 