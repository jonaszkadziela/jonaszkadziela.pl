<?php

use App\Http\Controllers\DocumentController;
use App\Http\Controllers\FeedbackController;
use App\Http\Controllers\FileController;
use App\Http\Controllers\FormController;
use App\Http\Controllers\JsonPageController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\SocialController;
use App\Http\Controllers\UserSettingController;
use Illuminate\Support\Facades\Route;

Route::get('/language-options', [UserSettingController::class, 'languageOptions']);
Route::get('/language/{code}', [UserSettingController::class, 'language']);
Route::post('/theme/{mode}', [UserSettingController::class, 'theme']);

Route::post('/feedback', [FeedbackController::class, 'store']);
Route::post('/contact', [FormController::class, 'contact']);

Route::get('/documents', [DocumentController::class, 'index']);
Route::get('/menus', [MenuController::class, 'index']);
Route::get('/socials', [SocialController::class, 'index']);
Route::get('/files/{file:slug}', [FileController::class, 'show']);
Route::get('/json-page/{jsonPage:name}', [JsonPageController::class, 'show']);

Route::get('{any}', fn () => view('vue'))->where('any', '.*');
