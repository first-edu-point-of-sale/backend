<?php

namespace App\Http\Controllers;

use App\Http\Resources\OrderResource;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Http\Request;

class OrderController extends BaseController
{
    public function getOrders()
    {
        $orders = Order::with('order_items.product')->get();
        return $this->response('',$orders,[]);
    }

    public function getOrder($order)
    {
        $order = Order::where('id' , $order)->with('order_items.product')->first();
        return $this->response('' , $order , []);
    }

    public function createOrder(Request $request)
    {
        $existOrder = Order::where('table' , $request->table)->first();
        if ($existOrder) {
            $order_item = new OrderItem();
            $order_item->order_id = $existOrder->id;
            $order_item->product_id = $request->product_id;
            $order_item->quantity = $request->quantity;
            $order_item->save();
            return $this->response('order added',[$existOrder , $order_item],[]);
        } else {
            $order = new Order();
            $order->table = $request->table;
            $order->save();
            $order_item = new OrderItem();
            $order_item->order_id = $order->id;
            $order_item->product_id = $request->product_id;
            $order_item->quantity = $request->quantity;
            $order_item->save();
            return $this->response('order created',[$order , $order_item],[]);
        }
    }


    public function payment($order)
    {
        Order::where('id',$order)->delete();
        OrderItem::where('order_id',$order)->delete();
    }
}
