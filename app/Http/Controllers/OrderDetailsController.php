<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\OrdersDetail;
use DB;

class OrderDetailsController extends Controller
{
    public function index()
    {
    	return 'a';

    }

    public function returnProductQty($id)
    {
   
        $orderDetail = OrdersDetail::where('id', $id)->first();
        $qty = DB::table('orders_details')
                    ->join('products', 'orders_details.product_id', '=', 'products.product_id' )
                    ->join('return_products', 'orders_details.id',  '=', 'return_products.orderDetail_id')
                    ->where('orders_details.order_id', $orderDetail->order_id)
                    ->select('products.product_name', 'orders_details.id', 'return_products.present_qty', 'return_products.previous_qty', 'return_products.created_at')
                    ->get();

       /* $d = OrdersDetail::where('order_id', $orderDetail->order_id)->with('product', 'returnProductQty')->get();
        $rts = [];
        foreach ($d as $key => $or) {
            foreach ($or->returnProductQty as $rt) {
                array_push($rts, [
                    'product_name' => $or->product->product_name,
                    'id' => $rt->id,
                    'present_qty' => $rt->present_qty,
                    'previous_qty' => $rt->previous_qty,
                    'created_at' => $rt->created_at,
                ]);
            }
        }
        return $rts;*/

        return response([
            'status' => true,
            'data'   => $qty
        ]);

    }
}
