<?php

use App\Http\Controllers\FeedbackController;
use App\Http\Controllers\LanguageController;
use Illuminate\Support\Facades\Route;

Route::get('/language/{code}', [LanguageController::class, 'change']);
Route::get('/language-options', [LanguageController::class, 'options']);

Route::post('/feedback', [FeedbackController::class, 'store']);

Route::get('{any}', fn () => view('vue'))->where('any', '.*');
