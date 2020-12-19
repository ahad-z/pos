<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Customer;
use App\Models\Order;
use App\Models\Payment;
use Illuminate\Support\Facades\Validator;

class CustomerController extends Controller
{
    public function index(Request $request)
    {

        try{
            $customers = new Customer;
            if(isset( $request->allPhone)){ 
                $customers = $customers->where('cust_phone', 'LIKE', '%' . $request->get('allPhone'). '%' );
            }    
             if(isset( $request->cust_phone)){ 
                $customers = $customers->where('cust_phone', 'LIKE', '%' . $request->get('cust_phone'). '%' );
            }
            $customers =  $customers->get();
            return response([
                'status'  => true,
                'message' => "Data retrieve success!",
                'data'    => $customers
            ]);

        }catch(\Exception $e){
            return response([
                'status'  => false,
                'message' => "No customer"
            ]);

        }
    }
    public function create()
    {

    }

    public function store(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'cust_name'  => 'required',
            'cust_phone'  => 'required|unique:customers',
            'cust_address'  => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => $validator->getMessageBag(),
            ]);
        }
        try {
            $customer = Customer::create([
                'cust_name' => $request->cust_name,
                'cust_phone' => $request->cust_phone,
                'cust_address' => $request->cust_address,
            ]);
            return response()->json([
                'status' => true,
                'message' => 'Customer Added Successfully',
                'customer' => $customer

            ], 200);

        } catch (Exception $e) {
            return response()->json([
                'status' => false,
                'message' => $e->getMessage()
            ]);
        }
    }


    public function show($id)
    {
        $customer = Customer::find($id);
        return response([
            'status' => true,
            'Customer' => $customer
        ]);
    }

    public function edit($id)
    {

    }
    public function update(Request $request, $id)
    {

        try{
            $customer = Customer::where('cust_id', $id)->first();
            $customer->cust_name  = $request->cust_name;
            $customer->cust_phone  = $request->cust_phone;
            $customer->cust_address  = $request->cust_address;
            $customer->update();
            return response()->json([
                'status'  => true,
                'message' => 'Customer Updated Successfully'
            ]);
        }catch(\Exception $e){
            return response()->json([
                'status'  => false,
                'message' => $e->getMessage()
            ]);
        }
    }
    public function destroy($id)
    {
        try {
            Customer::destroy($id);
            return response([
                'status' => true,
                'message' => "Delete Successfully"
            ]);
        } catch (\Exception $e) {
            return ['status' => false, 'message' => $e->getMessage()];
        }
    }

    public function CustomerallDelete(Request $request)
    {
        try{
            Customer::destroy($request->id);
            return response([
                'status' => true,
                'message' => "Customer delete Successfully",
                'total'=> count($request->id)
            ]);
        }catch(\Exception $e){
            return ['status' => false, 'message' => $e->getMessage()];
        }
    }

    public function getPayments($id)
    {
        $payments = Payment::where('order_id', $id)->get();
        return response([
            'data' => $payments
        ]);

    }

    public function customerOrders($id)
    {
        $orders = Order::orderBy('order_id', 'DESC')->with('customer')->where('cust_id', $id)->get();
        return response([
            'data' => $orders
        ]);
    }

    public function getPaymentsHistory($id)
    {
        $payments = Payment::where('cust_id', $id)->get();
        return response([
            'data' => $payments
        ]);

    }

}
