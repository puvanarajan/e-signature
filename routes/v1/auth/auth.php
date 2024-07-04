<?php

use App\Http\Controllers\Auth\AuthenticationController;
use App\Http\Controllers\Auth\RegistrationController;
use App\Http\Controllers\Auth\VerificationController;
use Illuminate\Support\Facades\Route;

// Registration API
Route::post('signup', [RegistrationController::class, 'register'])
    ->name('api.v1.auth.auth.register');

// Email verification API
Route::get('verify', [VerificationController::class, 'emailVerification'])
    ->name('api.v1.auth.auth.emailVerification');

// Login API
Route::post('login', [AuthenticationController::class, 'login'])
    ->name('api.v1.auth.auth.login');
