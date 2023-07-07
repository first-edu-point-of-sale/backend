<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class RecordResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' =>  $this->id,
            'product' => $this->product->name,
            'category' =>  $this->product->category->name,
            'quantity' => $this->quantity,
            'total' => $this->unitprice,
            'date' => $this->created_at->format('d-m-y')
        ];
    }
}
