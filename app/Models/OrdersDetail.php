<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrdersDetail extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function product()
    {
    	return $this->belongsTo(Product::class, 'product_id');

    }

     public function returnProductQty()
    {
    	return $this->HasMany(ReturnProduct::class, 'orderDetail_id');

    }

}
