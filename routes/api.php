<?php

use App\Http\Controllers\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Controllers\AuthControllers;

Route::get('/user', function (Request $request){
    return $request->user();
})->middleware('auth:sanctum');

// Auth routes

Route::group(['prefix'=>'auth'], function () {
    Route::post('register', [AuthController::class, 'register']);
    Route::post('login',[AuthController::class, 'login']);
    Route::post('logout',[AuthController::class, 'logout']);
    Route::post('refresh',[AuthController::class, 'refresh']);
    Route::post('profile',[AuthController::class, 'profile']);
});