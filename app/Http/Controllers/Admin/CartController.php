<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\CartResource;
use App\Models\Cart;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CartController extends Controller
{
    public function index()
    {
        $cart = CartResource::collection(Cart::all()) ;
        return $this->success($cart,"all products");
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
             'customer_id' => 'required',
             'quantity' => 'required',
             'product_id' => 'required'
         ]);

         if ($validator->fails()) {
           return $this->fail($validator->errors());
         }else{
             $cart = new Cart();
             $cart->customer_id = $request->customer_id;
             $cart->quantity = $request->quantity;
             $cart->product_id = $request->product_id;
             $cart->save();
             return $this->success(new CartResource($cart),"success");
         }

    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request ,$id)
    {

         $validator = Validator::make($request->all(), [
            'customer_id' => 'required',
            'quantity' => 'required',
            'product_id' => 'required'
         ]);

         if ($validator->fails()) {
          return $this->fail($validator->errors());
         }else{
             $cart = Cart::where('id',$id)->first();
             $cart->customer_id = $request->customer_id;
             $cart->quantity = $request->quantity;
             $cart->product_id = $request->product_id;
             $cart->update();
             return $this->success(new CartResource($cart),"updated");
         }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $cart = Cart::where('id$id',$id)->first();
        $cart->delete();
        return $this->response("deleted",[]);
    }
    public function show($id)
    {
        $cart = new CartResource(Cart::where('id$id',$id)->first());
        return $this->response("found",$cart);
    }

}
