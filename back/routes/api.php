<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProjectController;

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/project', [ProjectController::class, 'index']);
    Route::post('/project', [ProjectController::class, 'store']);
    Route::get('/project/check', [ProjectController::class, 'check']);
    Route::put('/project/{id}', [ProjectController::class, 'update']);
});
Route::post('/register',  [AuthController::class, 'store']);
Route::post('/login', [AuthController::class, 'index']);
