<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/',
    function (): \Illuminate\Http\JsonResponse
    {
        return response()->json([
            'model' => 'Module',
            'data' => \App\Models\Module::where('id', 1)->with('instructor', 'themes.subThemes')->get(),
        ]);
    }
);
