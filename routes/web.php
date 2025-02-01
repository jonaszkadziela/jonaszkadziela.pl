<?php

use App\Http\Controllers\FileController;
use App\Http\Controllers\UserSettingController;
use Illuminate\Support\Facades\Route;

Route::get('/language-options', [UserSettingController::class, 'languageOptions']);
Route::get('/language/{code}', [UserSettingController::class, 'language']);
Route::post('/theme/{mode}', [UserSettingController::class, 'theme']);

Route::get('/files/{file:slug}', [FileController::class, 'show']);

Route::get('{any}', fn () => view('vue'))->where('any', '.*');
