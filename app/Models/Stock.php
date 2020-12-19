<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Stock extends Model
{
    use HasFactory;
    protected $primaryKey = 'stocks_id';
    protected  $guarded   =[];

    public function products()
    {
    	return $this->belongsTo(Product::class, 'product_id');

    }

}
