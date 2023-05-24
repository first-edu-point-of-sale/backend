<?php

use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\CustomerController;
use Illuminate\Support\Facades\Route;


Route::post('logout', [AuthController::class,'logout']);

Route::apiResource('categories',CategoryController::class);
Route::apiResource('products',ProductController::class);
Route::apiResource('carts',CartController::class);

Route::get('get-products-by-category/{category}' , [CustomerController::class , 'getProductsByCategory']);
Route::post('take-order' , [CustomerController::class , 'takeOrder']);
