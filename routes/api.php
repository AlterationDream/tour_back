<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TourController;
use App\Http\Controllers\ServicesCategoryController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\SaleTagController;
use App\Http\Controllers\PlaceController;
use App\Http\Controllers\CurrencyController;
use App\Http\Controllers\PriceUnitController;
use App\Http\Controllers\InfoPageController;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


Route::get('/get-tours', [TourController::class, 'getTours']);
Route::get('/get-tour-details/{id}', [TourController::class, 'getTourDetails']);
Route::get('/get-top-categories', [ServicesCategoryController::class, 'getTopCategories']);
Route::get('/get-child-categories/{id}', [ServicesCategoryController::class, 'getChildCategories']);
Route::get('/get-category-listings/{id}', [ServiceController::class, 'getCategoryListings']);
Route::get('/get-sale-tags', [SaleTagController::class, 'getSaleTags']);
Route::get('/get-places', [PlaceController::class, 'getPlaces']);
Route::get('/get-currencies', [CurrencyController::class, 'getCurrencies']);
Route::get('/get-price-units', [PriceUnitController::class, 'getPriceUnits']);
Route::get('/get-about-page', [InfoPageController::class, 'getAboutPage']);
Route::get('/get-vip-page', [InfoPageController::class, 'getVIPPage']);