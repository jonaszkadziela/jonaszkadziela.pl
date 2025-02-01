<?php

use App\Http\Controllers\DocumentController;
use App\Http\Controllers\FeedbackController;
use App\Http\Controllers\FormController;
use App\Http\Controllers\JsonPageController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\SocialController;
use Illuminate\Support\Facades\Route;

Route::get('/documents', [DocumentController::class, 'index']);

Route::post('/feedback', [FeedbackController::class, 'store']);

Route::post('/contact', [FormController::class, 'contact']);

Route::get('/json-pages/{jsonPage:name}', [JsonPageController::class, 'show']);

Route::get('/menus', [MenuController::class, 'index']);

Route::get('/projects', [ProjectController::class, 'index']);
Route::get('/projects/{project:slug}', [ProjectController::class, 'show']);

Route::get('/socials', [SocialController::class, 'index']);
