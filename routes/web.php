<?php

use App\Http\Controllers\FileController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\UserSettingController;
use App\Policies\ApiPolicy;
use Illuminate\Support\Facades\Route;
use Spatie\Csp\AddCspHeaders;

Route::middleware(AddCspHeaders::class . ':' . ApiPolicy::class)->group(function () {
    Route::post('/theme/{mode}', [UserSettingController::class, 'theme']);
    Route::get('/users/current', [UserController::class, 'currentUser']);
});

Route::get('/language/{code}', [UserSettingController::class, 'language']);
Route::get('/files/{file:slug}', [FileController::class, 'show'])->middleware('cache.headers:public;max_age=2628000;etag');

Route::get('{any}', fn () => view('vue'))->where('any', '.*');
