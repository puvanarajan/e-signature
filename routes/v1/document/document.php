<?php

use App\Http\Controllers\Document\DocumentController;
use Illuminate\Support\Facades\Route;

// Upload document
Route::post('upload', [DocumentController::class, 'documentUpload'])
    ->name('api.v1.document.document.documentUpload');

// Share document
Route::post('share-document', [DocumentController::class, 'shareDocument'])
    ->name('api.v1.document.document.shareDocument');

// Sign document
Route::post('signed-document', [DocumentController::class, 'signedDocument'])
    ->name('api.v1.document.document.signedDocument');
