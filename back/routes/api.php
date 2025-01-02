<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProjectController;

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user', function (Request $request) {
        // ユーザー関連の処理
    });
    
    Route::post('/project', [ProjectController::class, 'store']);
    Route::get('/project/name', [ProjectController::class, 'show']);
});
Route::post('/register',  [AuthController::class, 'store']);
Route::post('/login', [AuthController::class, 'index']);
