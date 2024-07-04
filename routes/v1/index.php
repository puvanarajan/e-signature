<?php

use Illuminate\Support\Facades\Route;

Route::group(['middleware' => ['json.response']], function () {
    include 'Auth/index.php';
    include 'Document/index.php';
});
