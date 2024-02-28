<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\GroupController;
use App\Http\Controllers\ModuleController;
use App\Http\Controllers\ThemeController;
use App\Http\Controllers\SubThemeController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/
Route::apiResource('groups',GroupController::class);

Route::apiResource('modules', ModuleController::class);

Route::apiResource('themes', ThemeController::class);

Route::apiResource('sub_theme', SubThemeController::class);
