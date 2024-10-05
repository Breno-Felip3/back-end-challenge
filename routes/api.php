<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\FileController;
use App\Http\Controllers\WordController;
use Illuminate\Support\Facades\Route;

Route::get('/', function(){
    return response()->json(["message" => "Fullstack Challenge 🏅 - Dictionary"]);
});

Route::prefix('auth')->group(function(){
    Route::post('/signup', [AuthController::class, 'signup'])->name('register');
    Route::post('/signin', [AuthController::class, 'signin'])->name('login');
});

Route::middleware('auth:api')->group(function(){
    Route::post('/upload-txt', [FileController::class, 'uploadTxt']);

    Route::prefix('user')->group(function(){
        Route::get('/me', [AuthController::class, 'me'])->name('me');
        Route::get('/me/history', [WordController::class, 'historyByUser']);
        Route::get('/me/favorites', [WordController::class, 'favoritesByUser']);
    });

    Route::prefix('entries/en')->group(function(){
        Route::get('/', [WordController::class, 'index']);
        Route::get('/{word}', [WordController::class, 'show']);
        Route::post('/{word}/favorite', [WordController::class, 'favoriteWord']);
        Route::delete('/{word}/unfavorite', [WordController::class, 'removeFavoriteWord']);
    });
});


 