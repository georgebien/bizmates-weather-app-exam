<?php

use App\Http\Controllers\WeatherController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get(
    '/get-weather',
    [
        WeatherController::class, 
        'getWeather'
    ]
);

Route::get(
    '/get-forecast',
    [
        WeatherController::class, 
        'getForecast'
    ]
);

Route::get(
    '/get-places',
    [
        WeatherController::class, 
        'getPlaces'
    ]
);
