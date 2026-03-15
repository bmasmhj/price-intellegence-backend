<?php

use App\Http\Controllers\Api\CompanyController;
use App\Http\Controllers\Api\UserProductController;
use App\Http\Controllers\Api\PricingHistoryController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Price Intelligence API Routes
|--------------------------------------------------------------------------
*/

// Companies
Route::apiResource('companies', CompanyController::class);
Route::get('companies/{company}/logs', [CompanyController::class, 'logs']);

// User Products
Route::apiResource('user-products', UserProductController::class);
Route::get('user-products/{userProduct}/linked-products', [UserProductController::class, 'linkedProducts']);
Route::post('user-products/{userProduct}/link', [UserProductController::class, 'linkProduct']);
Route::post('user-products/{userProduct}/unlink', [UserProductController::class, 'unlinkProduct']);

// Product search
Route::post('products/search-by-url', [UserProductController::class, 'searchProductByUrl']);
// Pricing History (scoped to a product)
Route::get('products/{product}/pricing-history', [PricingHistoryController::class, 'index']);
