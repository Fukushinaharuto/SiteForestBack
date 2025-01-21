<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\PageController;

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/verifyToken', [AuthController::class, 'search']);
    Route::get('/project', [ProjectController::class, 'index']);
    Route::post('/project', [ProjectController::class, 'store']);
    Route::post('/project/check', [ProjectController::class, 'check']);
    Route::delete('/project/destroy', [ProjectController::class, 'destroy']);
    Route::patch('/project/{id}', [ProjectController::class, 'update']);
    Route::get('/page', [PageController::class, 'index']);
    Route::post('/page', [PageController::class, 'store']);
    
});
Route::post('/register',  [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

