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

Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware(['auth:sanctum'])->group(function () {
    Route::get('/news', 'App\Http\Controllers\NewsController@index');
    Route::post('/news', 'App\Http\Controllers\NewsController@store');
    Route::get('/news/{id}', 'App\Http\Controllers\NewsController@show');
    Route::put('/news/{id}', 'App\Http\Controllers\NewsController@update');
    Route::delete('/news/{id}', 'App\Http\Controllers\NewsController@destroy');
});
