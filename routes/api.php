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

//Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//    return $request->user();
//});


Route::get('catalogs', '\App\Http\Controllers\Api\CatalogController@index');
Route::post('catalogs', '\App\Http\Controllers\Api\CatalogController@store');
Route::get('products', '\App\Http\Controllers\Api\ProductController@index');
Route::post('products', '\App\Http\Controllers\Api\ProductController@store');
Route::post('prices', '\App\Http\Controllers\Api\PricesByGroupController@store');
Route::get('/products/random', [\App\Http\Controllers\Api\ProductController::class, 'getRandomProducts']);
Route::get('/products/{id}', [\App\Http\Controllers\Api\ProductController::class, 'show']);





Route::post('verify' , [\App\Http\Controllers\Api\AuthController::class, 'SendVerificationCode']);
Route::post('login' , [\App\Http\Controllers\Api\AuthController::class, 'verifyByCode']);

Route::post('favourites', [\App\Http\Controllers\Api\FavouriteController::class, 'store']);
Route::get('favourites', [\App\Http\Controllers\Api\FavouriteController::class, 'index']);

Route::post('basket', [\App\Http\Controllers\Api\BasketController::class, 'store']);
Route::get('basket', [\App\Http\Controllers\Api\BasketController::class, 'index']);

Route::post('getCityFromCoordinates' , [\App\Http\Controllers\Api\LocationController::class, 'getCityFromCoordinates']);


//DEV STAGE
//Route::get('createProduct', [\App\Http\Controllers\Api\ProductController::class, 'create']);
//Route::get('createCatalog', [\App\Http\Controllers\Api\CatalogController::class, 'create']);
//Route::get('createPrices', [\App\Http\Controllers\Api\PricesByGroupController::class, 'create']);





