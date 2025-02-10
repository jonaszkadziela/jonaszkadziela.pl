<?php

use App\Http\Controllers\DocumentController;
use App\Http\Controllers\FeedbackController;
use App\Http\Controllers\FormController;
use App\Http\Controllers\JsonPageController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\SocialController;
use App\Http\Controllers\TagController;
use Illuminate\Support\Facades\Route;

Route::get('/documents', [DocumentController::class, 'index']);
Route::get('/documents/{document:slug}', [DocumentController::class, 'show']);

Route::post('/feedback', [FeedbackController::class, 'store']);

Route::post('/contact', [FormController::class, 'contact']);

Route::get('/json-pages/{jsonPage:name}', [JsonPageController::class, 'show']);

Route::get('/menus', [MenuController::class, 'index']);

Route::get('/posts', [PostController::class, 'index']);
Route::get('/posts/{slugWithId}', [PostController::class, 'show']);

Route::get('/projects', [ProjectController::class, 'index']);
Route::get('/projects/{project:slug}', [ProjectController::class, 'show']);

Route::get('/socials', [SocialController::class, 'index']);

Route::get('/tags', [TagController::class, 'index']);
