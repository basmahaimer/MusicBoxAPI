<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ArtistController;
use App\Http\Controllers\AlbumController;
use App\Http\Controllers\SongController;
use App\Http\Controllers\AuthController;

// Auth API
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');

// Swagger routes
Route::get('api/documentation', [\L5Swagger\Http\Controllers\SwaggerController::class, 'api']);
Route::get('docs', [\L5Swagger\Http\Controllers\SwaggerController::class, 'docs']);
Route::get('docs/asset/{asset}', [\L5Swagger\Http\Controllers\SwaggerController::class, 'asset']);

// Routes protégées par authentification
Route::middleware('auth:sanctum')->group(function () {

    // Infos utilisateur connecté
    Route::get('/user', fn(Request $request) => $request->user());

    // CRUD Artists, Albums et Songs
    Route::apiResource('artists', ArtistController::class);
    Route::apiResource('albums', AlbumController::class);
    Route::apiResource('songs', SongController::class);

    // Toutes les chansons d’un album
    Route::get('albums/{album}/songs', [AlbumController::class, 'songs']);
});
