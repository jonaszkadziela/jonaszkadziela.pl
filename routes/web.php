<?php

use App\Http\Controllers\FeedbackController;
use App\Http\Controllers\JsonPageController;
use App\Http\Controllers\UserSettingController;
use Illuminate\Support\Facades\Route;

Route::get('/language-options', [UserSettingController::class, 'languageOptions']);
Route::get('/language/{code}', [UserSettingController::class, 'language']);
Route::post('/theme/{mode}', [UserSettingController::class, 'theme']);

Route::post('/feedback', [FeedbackController::class, 'store']);

Route::get('/json-page/{jsonPage:name}', [JsonPageController::class, 'show']);

Route::get('{any}', fn () => view('vue'))->where('any', '.*');
