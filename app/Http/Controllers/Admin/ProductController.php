<?php

namespace App\Http\Controllers\Admin;

use App\Models\Product;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\BaseController;
use App\Http\Resources\ProductResource;
use Illuminate\Support\Facades\Validator;

class ProductController extends BaseController
{
    public function index()
    {
        $product = ProductResource::collection(Product::all()) ;
       return $this->success($product,"all products");
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
         $validator = Validator::make($request->all(), [
             'name' => 'required|max:255',
             'description' => 'required',
             'price' => 'required',
             'category_id' => 'required'
         ]);

         if ($validator->fails()) {
           return $this->fail($validator->errors());
         }else{
             $product = new Product();
             $product->name = $request->name;
             $product->slug = Str::of($request->name)->slug();
             $product->description = $request->description;
             $product->price = $request->price;
             $product->category_id = $request->category_id;
             $product->save();
             return $this->success(new ProductResource($product),"success");
         }

    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request ,$slug)
    {

         $validator = Validator::make($request->all(), [
            'name' => 'required|max:255',
            'description' => 'required',
            'price' => 'required',
            'category_id' => 'required'
         ]);

         if ($validator->fails()) {
          return $this->fail($validator->errors());
         }else{
             $product = Product::where('slug',$slug)->first();
             $product->name = $request->name;
             $product->slug = Str::of($request->name)->slug();
             $product->description = $request->description;
             $product->price = $request->price;
             $product->category_id = $request->category_id;
             $product->update();
             return $this->success(new ProductResource($product),"updated");
         }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($slug)
    {
        $product = Product::where('slug',$slug)->first();
        $product->delete();
        return $this->response("deleted",[]);
    }
    public function show($slug)
    {
        $product = new ProductResource(Product::where('slug',$slug)->first());
        return $this->response("found",$product);
    }
}
