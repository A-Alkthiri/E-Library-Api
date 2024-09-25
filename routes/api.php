<?php

use App\Http\Controllers\Api\AdController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\ContentController;
use App\Http\Controllers\Api\ContentTypeController;
use App\Http\Controllers\Api\MediaController;
use App\Http\Controllers\Api\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/* Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');
 */

// Auth routes
Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login']);

// Protect routes with Sanctum's auth middleware
Route::middleware('auth:sanctum')->group(function () {
    Route::post('logout', [AuthController::class, 'logout']);
    Route::get('profile', [AuthController::class, 'profile']);

    // Example of protected content routes
    Route::apiResource('contents', ContentController::class);
    Route::apiResource('categories', CategoryController::class);
    Route::apiResource('content-types', ContentTypeController::class);
    Route::apiResource('ads', AdController::class);
    Route::apiResource('media', MediaController::class);
    Route::apiResource('users', UserController::class);
});
