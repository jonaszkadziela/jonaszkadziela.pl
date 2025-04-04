<?php

use App\Http\Controllers\Api\AppSettingController;
use App\Http\Controllers\Api\DocumentController;
use App\Http\Controllers\Api\FeedbackController;
use App\Http\Controllers\Api\FormController;
use App\Http\Controllers\Api\GlobalSearchController;
use App\Http\Controllers\Api\JsonPageController;
use App\Http\Controllers\Api\MenuController;
use App\Http\Controllers\Api\PostController;
use App\Http\Controllers\Api\ProjectController;
use App\Http\Controllers\Api\SocialController;
use App\Http\Controllers\Api\TagController;
use Illuminate\Support\Facades\Route;

Route::get('/language-options', [AppSettingController::class, 'languageOptions']);
Route::get('/optional-features', [AppSettingController::class, 'optionalFeatures']);

Route::get('/documents', [DocumentController::class, 'index']);
Route::get('/documents/{document:slug}', [DocumentController::class, 'show']);

Route::post('/feedback', [FeedbackController::class, 'store']);

Route::post('/contact', [FormController::class, 'contact']);

Route::get('/search/by-tags', [GlobalSearchController::class, 'searchByTags']);

Route::get('/json-pages/{jsonPage:name}', [JsonPageController::class, 'show']);

Route::get('/menus', [MenuController::class, 'index']);

Route::get('/posts', [PostController::class, 'index']);
Route::get('/posts/{slugWithId}', [PostController::class, 'show']);

Route::get('/projects', [ProjectController::class, 'index']);
Route::get('/projects/{project:slug}', [ProjectController::class, 'show']);

Route::get('/socials', [SocialController::class, 'index']);

Route::get('/tags', [TagController::class, 'index']);
