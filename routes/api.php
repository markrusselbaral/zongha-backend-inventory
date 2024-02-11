<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Item\ItemController;
use App\Http\Controllers\User\UserController;
use App\Http\Controllers\Client\ClientController;
use App\Http\Controllers\Pricing\PricingController;
use App\Http\Controllers\Category\CategoryController;
use App\Http\Controllers\Warehouse\WarehouseController;

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


Route::prefix('user')->group(function () {
    Route::get('/', [UserController::class, 'index']);
    Route::post('/', [UserController::class, 'save']);
    Route::get('/{id}', [UserController::class, 'edit']);
    Route::put('/{id}', [UserController::class, 'update']);
    Route::delete('/{id}', [UserController::class, 'delete']);
});

Route::prefix('client')->group(function() {
    Route::get('/', [ClientController::class, 'index']);
    Route::post('/', [ClientController::class, 'save']);
    Route::get('/{id}', [ClientController::class, 'edit']);
    Route::put('/{id}', [ClientController::class, 'update']);
    Route::delete('/{id}', [ClientController::class, 'delete']);
});

Route::prefix('pricing')->group(function() {
    Route::get('/', [PricingController::class, 'index']);
    Route::post('/', [PricingController::class, 'save']);
    Route::get('/{id}', [PricingController::class, 'edit']);
    Route::put('/{id}', [PricingController::class, 'update']);
    Route::delete('/{id}', [PricingController::class, 'delete']);
});

Route::prefix('category')->group(function() {
    Route::get('/', [CategoryController::class, 'index']);
    Route::post('/', [CategoryController::class, 'store']);
    Route::get('/{id}', [CategoryController::class, 'show']);
    Route::put('/{id}', [CategoryController::class, 'update']);
    Route::delete('/{id}', [CategoryController::class, 'destroy']);
});

Route::prefix('items')->group(function() {
    Route::get('/', [ItemController::class, 'index']);
    Route::get('/create', [ItemController::class, 'create']);
    Route::post('/', [ItemController::class, 'store']);
    Route::get('/{id}', [ItemController::class, 'show']);
    Route::put('/{id}', [ItemController::class, 'update']);
    Route::delete('/{id}', [ItemController::class, 'destroy']);

});

Route::prefix('retrieve')->group( function() {
    Route::get('/', [ItemController::class, 'showRetrieve']);
    Route::get('/{id}', [ItemController::class, 'restore']);
});

Route::prefix('warehouse')->group(function() {
    Route::get('/', [WarehouseController::class, 'index']);
    Route::get('/{id}', [WarehouseController::class, 'edit']);
    Route::post('/', [WarehouseController::class, 'store']);
    Route::put('/{id}', [WarehouseController::class, 'update']);
    Route::delete('/{id}', [WarehouseController::class, 'destroy']);
});

// Route::middleware(['auth', 'role:Admin'])->group(function () {

// });

// Route::middleware(['auth', 'role:User'])->group(function () {

// });


