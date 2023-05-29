<?php

namespace App\Http\Controllers;

use App\Http\Resources\OrderResource;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Http\Request;

class OrderController extends BaseController
{
    public function allOrder()
    {
        $order = Order::all();
        return $this->response('',$order,[]);
    }

    public function createOrder(Request $request)
    {
        $order = new Order();
        $order->table = $request->table;
        $order->save();
        $order_item = new OrderItem();
        $order_item->order_id = $order->id;
        $order_item->product_id = $request->product_id;
        $order_item->quantity = $request->quantity;
        $order_item->save();
        return $this->response('',$order,[]);
    }


    public function payment($order)
    {
        Order::where('id',$order)->delete();
        OrderItem::where('order_id',$order)->delete();
    }
}
