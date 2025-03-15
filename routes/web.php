<?php

use App\Http\Controllers\FileController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\UserSettingController;
use Illuminate\Support\Facades\Route;

Route::get('/language/{code}', [UserSettingController::class, 'language']);
Route::post('/theme/{mode}', [UserSettingController::class, 'theme']);

Route::get('/files/{file:slug}', [FileController::class, 'show']);
Route::get('/users/current', [UserController::class, 'currentUser']);

Route::get('{any}', fn () => view('vue'))->where('any', '.*');
