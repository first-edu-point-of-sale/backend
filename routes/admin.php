<?php
use App\Http\Controllers\Admin\CartController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\OrderController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\RecordController;

Route::post('logout', [AuthController::class,'logout']);

Route::apiResource('categories',CategoryController::class);
Route::apiResource('products',ProductController::class);
Route::apiResource('invoices',InvoiceController::class);

Route::get('get-products-by-category/{category}' , [CustomerController::class , 'getProductsByCategory']);
Route::post('create-order' , [OrderController::class , 'createOrder']);
Route::get('get-orders'  , [OrderController::class , 'getOrders']);
Route::get('records'  , [RecordController::class , 'index']);
Route::get('get-orders/{order}'  , [OrderController::class , 'getOrder']);
Route::delete('payment' , [OrderController::class , 'payment']);
