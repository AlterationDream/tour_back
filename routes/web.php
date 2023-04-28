<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\TourController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\ServicesCategoryController;
use App\Http\Controllers\PlaceController;
use App\Http\Controllers\CurrencyController;
use App\Http\Controllers\SaleTagController;
use App\Http\Controllers\PriceUnitController;
use App\Http\Controllers\InfoPageController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Example Routes
Route::get('/', function (){
    if (Auth::check()) return redirect('/dashboard');
    return view('landing');
})->name('login');
Route::post('/', [AuthController::class, 'login']);


Route::group(['middleware' => 'auth'], function () {
    Route::view('/dashboard', 'dashboard')->name('dashboard');
    Route::get('/signout', [AuthController::class, 'signOut'])->name('signOut');

    /* CRUD Groups */
    Route::controller(TourController::class)->prefix('/tours')->group(function() {
        Route::get('/', 'index')->name('tours');
        Route::get('/search', 'searchTours');
        Route::get('/create', 'create')->name('tours.create');
        Route::post('/create', 'store')->name('tours.store');
        Route::get('/{id}/edit', 'edit')->name('tours.edit');
        Route::post('/{id}/edit', 'update')->name('tours.update');
        Route::get('/{id}/delete', 'delete')->name('tours.delete');
    });
    Route::redirect('/services', '/services/listings');
    Route::controller(ServicesCategoryController::class)->prefix('/services/categories')->group(function() {
        Route::get('/', 'index')->name('services.categories');
        Route::post('/create', 'store')->name('services.categories.create');
        Route::post('/update', 'update')->name('services.categories.update');
        Route::get('/get-categories', 'getList')->name('services.categories.get-categories');;
        Route::get('/delete', 'delete')->name('services.categories.delete');
    });
    Route::controller(ServiceController::class)->prefix('/services/listings')->group(function () {
        Route::get('/', 'index')->name('services');
        Route::get('/create', 'create')->name('services.create');
        Route::post('/create', 'store');
        Route::get('/{id}/edit/', 'edit')->name('services.edit');
        Route::post('/{id}/edit/', 'update')->name('services.update');
        Route::get('/{id}/delete', 'delete')->name('services.delete');
        Route::get('/get-services', 'getList')->name('services.get');
    });
    Route::prefix('/services/settings')->group(function () {
        Route::get('/', [ServiceController::class, 'settings'])->name('services.settings');
        Route::post('/create-place', [PlaceController::class, 'store'])->name('places.create');
        Route::post('/update-place', [PlaceController::class, 'update'])->name('places.update');
        Route::get('/delete-place', [PlaceController::class, 'delete'])->name('places.delete');
        Route::get('/get-places', [PlaceController::class, 'getList'])->name('places.get');

        Route::post('/create-currency', [CurrencyController::class, 'store'])->name('currencies.create');
        Route::post('/update-currency', [CurrencyController::class, 'update'])->name('currencies.update');
        Route::get('/delete-currency', [CurrencyController::class, 'delete'])->name('currencies.delete');
        Route::get('/get-currencies', [CurrencyController::class, 'getList'])->name('currencies.get');

        Route::post('/create-price-unit', [PriceUnitController::class, 'store'])->name('price-units.create');
        Route::post('/update-price-unit', [PriceUnitController::class, 'update'])->name('price-units.update');
        Route::get('/delete-price-unit', [PriceUnitController::class, 'delete'])->name('price-units.delete');
        Route::get('/get-price-units', [PriceUnitController::class, 'getList'])->name('price-units.get');

        Route::post('/create-sale-tag', [SaleTagController::class, 'store'])->name('sale-tags.create');
        Route::post('/update-sale-tag', [SaleTagController::class, 'update'])->name('sale-tags.update');
        Route::get('/delete-sale-tag', [SaleTagController::class, 'delete'])->name('sale-tags.delete');
        Route::get('/get-sale-tags', [SaleTagController::class, 'getList'])->name('sale-tags.get');
    });

    Route::prefix('/info-pages')->group(function () {
        Route::get('/about-us', [InfoPageController::class, 'aboutUs'])->name('info-pages.about-us');
        Route::get('/vip', [InfoPageController::class, 'vip'])->name('info-pages.vip');
        Route::post('/save', [InfoPageController::class, 'update'])->name('info-pages.update');
    });
});
