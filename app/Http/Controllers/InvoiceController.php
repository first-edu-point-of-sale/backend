<?php

namespace App\Http\Controllers;

use App\Http\Resources\InvoiceResource;
use App\Models\Invoice;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use App\Http\Controllers\BaseController;

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
            $order =   Order::where('id',$request->order)->delete();
            OrderItem::where('order_id',$order)->delete();
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
