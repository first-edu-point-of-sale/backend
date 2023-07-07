<?php

namespace App\Models;

use App\Models\Record;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
    public function order_items()
    {
        return $this->hasMany(OrderItem::class);
    }
    public function records()
    {
        return $this->hasMany(Record::class);
    }
}
