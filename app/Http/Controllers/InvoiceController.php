<?php

namespace App\Http\Controllers;

use App\Http\Resources\InvoiceResource;
use App\Models\Invoice;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use App\Http\Controllers\BaseController;
use App\Models\Record;

class InvoiceController extends BaseController
{

    public function index()
    {
        $invoice = InvoiceResource::collection(Invoice::all());
        return $this->success($invoice);
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
         $invoice = Invoice::create([
            'table' => $request->table,
            'products' =>  json_encode($request->products),
            'total' => $request->total
        ]);
        if ($invoice){
             Order::where('id',$request->order)->delete();
            $orderitems =  OrderItem::with('product')->where('order_id',$request->order)->get();
            
            $orderitems->map(function ($orderitem) {
                $record = new Record();
                $record->product_id = $orderitem->product->id;
                $record->category_id= $orderitem->product->category_id;
                $record->unitprice = $orderitem->product->price * $orderitem->quantity;
                $record->quantity = $orderitem->quantity;
                
                // Save the record
                $record->save();
                
                // Delete the original OrderItem
                $orderitem->delete();
            });
            return $this->response('',['data' => $request->all()]);
        }else{
            return $this->response('something went wrong',[],404,false);
        }

    }

    public function show(Invoice $invoice)
    {
        //
    }

    public function edit(Invoice $invoice)
    {
        //
    }

    public function update(Request $request, Invoice $invoice)
    {
        //
    }

    public function destroy(Invoice $invoice)
    {
        //
    }
}
