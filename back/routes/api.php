<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('/register',  [AuthController::class, 'store']);
Route::post('/login', [AuthController::class, 'index']);

Route::get('/hello', function(){
    return response()->json([
        'hello' => "おはよう",
    ]);
});