<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;
    protected $primaryKey = 'cust_id';
    protected $guarded = [];

    public function orders()
    {
    	return $this->HasMany(Order::class, 'cust_id');

    }
}
