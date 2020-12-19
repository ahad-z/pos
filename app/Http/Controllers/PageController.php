<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use PDF;
use App\Models\Order; 

class PageController extends Controller
{
    public function index()
    {

        return view('pos.Auth.Layout');
    }
    public function dashBoard()
    {
        return view('pos.Master.master');
    }
    public function verifyLoginEmail(Request $request)
    {
    	if (! $request->hasValidSignature()) {
	        abort(401);
	    }
	   /* $user = User::whereEmail($request->email)->first();
	    return response([
	    	'status' => true,
	    	'message'=> 'right',
	    	'eamil'  => $user
	    ]);
	    return redirect()->route('users.changepassView');
	    return view('pos.forgetPass');*/
        return redirect('/update-password');
    }
    public function generatePDF($id)
    {
        $order = Order::with('orderDetails.product.units', 'payments', 'customer')->where('order_id', $id)->first();
        /*return $order->payments->sum('amount');*/
        $discount_type =  $order->discount_type;
       if($discount_type == '%'){
           $discount_type = 'percent'; 
       }else{
        $discount_type = 'cash';
       }
        return view('myPDF', compact('order', 'discount_type'));
    }


}
