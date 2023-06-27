<?php

use App\Models\Customer;
use App\Models\OrderItem;
use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    return OrderItem::with('product')->where('order_id',8)->get();
});
// Route::get('/create', function () {
//     $customer = new Customer();
//     $customer->table = "5";
//     $customer->save();
//     return "success";
// });
