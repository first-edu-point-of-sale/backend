<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Customer;
use Illuminate\Http\Request;
use App\Http\Controllers\BaseController;
use App\Http\Resources\CategoryResource;

class CustomerController extends BaseController
{
    public function getProductsByCategory ($category) {
        $categories = Category::where('slug' , $category)->with('products')->first();
        return $this->success(new CategoryResource($categories) , 'products by categories');
    }

    public function takeOrder(Request $request)
    {
        return $request->all();
    }
}
