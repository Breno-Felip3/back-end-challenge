<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\FileController;
use App\Http\Controllers\WordController;
use App\Http\Middleware\HeaderMiddleware;
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
        Route::get('/me', [AuthController::class, 'me'])->name('me')->middleware(HeaderMiddleware::class);
        Route::get('/me/history', [WordController::class, 'historyByUser'])->middleware(HeaderMiddleware::class);
        Route::get('/me/favorites', [WordController::class, 'favoritesByUser'])->middleware(HeaderMiddleware::class);
    });

    Route::prefix('entries/en')->group(function(){
        Route::get('/', [WordController::class, 'index'])->middleware(HeaderMiddleware::class);
        Route::get('/{word}', [WordController::class, 'show'])->name('word.show')->middleware(HeaderMiddleware::class);
        Route::post('/{word}/favorite', [WordController::class, 'favoriteWord'])->middleware(HeaderMiddleware::class);
        Route::delete('/{word}/unfavorite', [WordController::class, 'removeFavoriteWord']);
    });
});


 