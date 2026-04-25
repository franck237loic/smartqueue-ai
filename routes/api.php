<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route de test API
Route::get('/test', function () {
    return response()->json([
        'message' => 'SmartQueue API is working!',
        'version' => '1.0.0',
        'timestamp' => now()->toISOString()
    ]);
});