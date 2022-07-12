<?php

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
Route::group(['prefix' => 'cake'], function (){
    Route::get('/', [\App\Http\Controllers\Api\CakeController::class, 'index']);
    Route::get('/{id}', [\App\Http\Controllers\Api\CakeController::class, 'show']);
    Route::delete('/{id}', [\App\Http\Controllers\Api\CakeController::class, 'destroy']);
    Route::group(['middleware' => ['validJson']], function () {
        Route::post('/', [\App\Http\Controllers\Api\CakeController::class, 'store']);
        Route::put('/{id}', [\App\Http\Controllers\Api\CakeController::class, 'update']);
    });
});
