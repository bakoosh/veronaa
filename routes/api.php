<?php

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


Route::get('api/test' , [\App\Http\Controllers\TestController::class, 'test']);
Route::post('catalogs', '\App\Http\Controllers\Api\CatalogController@store');
Route::post('products', '\App\Http\Controllers\Api\ProductController@store');
Route::post('prices', '\App\Http\Controllers\Api\PricesByGroupController@store');
