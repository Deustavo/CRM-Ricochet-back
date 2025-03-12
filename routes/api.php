<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MeetingController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;

Route::post('/register', [AuthController::class, 'register']);

Route::post('/login', [AuthController::class, 'login']);

Route::middleware(['auth:sanctum'])->group(function () {
    Route::apiResource('meetings', MeetingController::class);

    Route::get('/logout', [AuthController::class, 'logout']);
    Route::get('/user', [UserController::class, 'user']);
    Route::put('/user/{id}', [UserController::class, 'update']);
    Route::delete('/user/{id}', [UserController::class, 'delete']);
});
