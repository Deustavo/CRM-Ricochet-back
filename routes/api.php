<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MeetingController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;

Route::post('/register', [AuthController::class, 'register']);

Route::post('/login', [AuthController::class, 'login']);

Route::middleware(['auth:sanctum'])->group(function () {
    Route::apiResource('meetings', MeetingController::class);
    Route::get('/meetings/user/{id}', [MeetingController::class, 'userMeetings']);
    Route::get('/logout', [AuthController::class, 'logout']);

    // User Routes
    Route::get('/user', [UserController::class, 'user']);
    Route::get('/users', [UserController::class, 'getAllUsers'])->name('user.getAll');
    Route::put('/users/{id}', [UserController::class, 'update'])->name('user.update');
    Route::delete('/users/{id}', [UserController::class, 'delete'])->name('user.delete');
});
