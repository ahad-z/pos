<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;
    protected $primaryKey = 'order_id';
    protected $guarded = [];
    
    public function orderDetails()
    {
    	return $this->hasMany(OrdersDetail::class, 'order_id');
    }

    public function payments()
    {
    	return $this->hasMany(Payment::class, 'order_id');

    }

    public function customer()
    {
        return $this->belongsTo(Customer::class, 'cust_id');

    }

}
