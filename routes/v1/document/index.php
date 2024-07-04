<?php

use Illuminate\Support\Facades\Route;

Route::middleware('auth:api')->group(function () {
    Route::prefix('documents')->group(function () {
        include 'document.php';
    });
});
