<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrdersDetail;
use App\Models\Payment;
use App\Models\ReturnProduct;
use App\Models\Stock;
use Carbon\Carbon;
use DB;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        
        $orders = Order::orderBy('order_id', 'DESC')->with('orderDetails.product.units', 'payments', 'customer');

        if($request->searchKey && $request->date == null){

            if(isset($request->searchKey))
            {
                $orders = $orders->where('invoice_number', 'LIKE', '%' . $request->get('searchKey'). '%' );
            }
        }

        if(isset($request->searchKey) && isset($request->date)){

            $start_date = $request->searchKey;                        
            $end_date   = $request->date;

            if($start_date == $end_date ){

                $orders     = $orders->whereDate('created_at', $start_date);

            }else{

                $orders     = $orders->whereBetween('created_at', [$start_date, $end_date]);
            }
        }

        $orders =  $orders->get();

    	return response([
            'status' => true,
            'data'   => $orders
        ]);
    }

    public function productSubTotal($product)
    {
        $st = $product['product_price'] * $product['qty'];

        if($product['discount_type'] === '%'){
            return $st - (($st * $product['discount']) / 100);
        }else{
            return $st - $product['discount'];
        }
    }

    public function store(Request $request)
    {
        $response = [];
        foreach ($request->products as $product) {
            if (!Stock::where('product_id', $product['product_id'])->where('quantity', '>=', $product['qty'])->exists()) {
                $response['product_not_in_stocks'][] = $product['product_name'];
            }else{
                $test = Stock::where('product_id', $product['product_id'])->first();
                $subtraction = $test->quantity - $product['qty'];
                $test->update([
                    'quantity' => $subtraction
                ]);
            }
        }
        if (isset($response['product_not_in_stocks'])) {
            return response([
                'status'  => false,
                'message' => $response
            ]);
        }
        if(is_float($request->total)){
            $total_replace =  str_replace('.', '-', $request->total);
        }else{
            $total_replace = $request->total;
        }

        if($request->cust_id){
            $invoice_number = substr($request->cust_name, 0, 3).'-'. $total_replace.'-'.$request->cust_id;
        }else{
            $invoice_number = substr($request->cust_name, 0, 3).'-'. $total_replace.'-'.rand(0,100);
        }

        $due = $request->total - $request->payment['payment_total'];

        if($due){
            $status = 'due';
        }else{
            $status = 'paid';
        }

    	try{

    		$order = Order::create([
                'cust_id'         => $request->cust_id,
                'invoice_number'  => $invoice_number,
                'discount_amount' => $request->discount,
                'discount_type'   => $request->discount_type,
                'sub_total'       => $request->subTotal,
                'total'           => $request->total,
                'due'             => $due,
                'status'          => $status,
    		]);
            if(isset($order)){
                foreach ($request->products as $product ) {
                    OrdersDetail::create([
                        'order_id'         => $order->order_id,
                        'product_id'       => $product['product_id'],
                        'discount_type'    => $product['discount_type'],
                        'discount_amount'  => $product['discount'],
                        'product_subtotal' => $this->productSubTotal($product),
                        'qty'              => $product['qty']
                    ]);
                }
            }
            $dueAmount = $request->total - $request->payment['payment_total'];

            if($dueAmount == 0){
                $status = 0;
            }else{
                $status = 1;
            }

            Payment::create([
                'order_id'     => $order->order_id,
                'cust_id'      => $request->cust_id,
                'amount'       => $request->payment['payment_total'],
                'payment_type' => $request->payment['payment_type'],
            ]);

            // TODO: Generate PDF

    		return response([
                'status' => true,
                'order'  => $order,
                /*'invoice_url' => asset('something.pdf')*/
    		]);

    	}catch(\Exception $e){
    		return response([
                'status'  => true,
                'message' => $e->getMessage()
    		]);
    	}
    		 	
    }

    public function show($id)
    {
        $orderData = Order::with('orderDetails.product.units', 'payments', 'customer')
            ->where('order_id', $id)
            ->first();

        $orderPayment = Payment::where('order_id', $id)->get();


        $order = [
            'discount'      => $orderData->discount_amount,
            'discount_type' => $orderData->discount_type,
            
            'cust_id'       => $orderData->cust_id,
            'cust_name'     => $orderData->customer ? $orderData->customer->cust_name : 'Walk in customer',
            
            'total'         => $orderData->total,
        ];

        foreach ($orderData->orderDetails as $orderDetail) {
            $order['products'][] = [
                'orderDetail_id' => $orderDetail->id,
                'discount'       => $orderDetail->discount_amount,
                'discount_type'  => $orderDetail->discount_type,
                'product_id'     => $orderDetail->product_id,
                'sub_total'      => $this->productSubTotal($orderDetail->product),
                'product_name'   => $orderDetail->product->product_name,
                'product_price'  => $orderDetail->product->selling_price,
                'qty'            => $orderDetail->qty,
            ];
        }
        $payment = [
            'payment_total' => $orderPayment->sum('amount')

        ];
        return response([
            'status'  => true,
            'order'   => $order,
            'payment' => $payment
        ]);
    }

    public function update(Request $request, $id)
    {
        $payment = Payment::where('order_id', $id)->get();
        $payAbleAmount = $payment->sum('amount');
        $due = $request->total - $payAbleAmount;


        if($request->total > $payAbleAmount){
            $status = 'due';
        }else{
            $status = 'return';
        }


        try{

            $order = Order::where('order_id', $id)->first();
            $order->discount_type   = $request->discount_type;
            $order->discount_amount = $request->discount;
            $order->status          = $status;
            $order->sub_total       = $request->subTotal;
            $order->due             = abs($due);
            $order->total           = $request->total;
            $order->update();

            
            foreach ($request->products as $orderDetail) {

                if (isset($orderDetail['orderDetail_id'])) {
                    $OD = OrdersDetail::where([
                        'order_id'         => $id,
                        'product_id'       => $orderDetail['product_id']
                    ])->first();

                    if ($OD->qty > $orderDetail['qty']) {
                        ReturnProduct::create([
                            'orderDetail_id' => $orderDetail['orderDetail_id'],
                            'present_qty'    => $orderDetail['qty'],
                            'previous_qty'   => $OD->qty,

                        ]);

                        $OD->update([
                            'discount_type'    => $orderDetail['discount_type'], 
                            'discount_amount'  => $orderDetail['discount'],
                            'product_subtotal' => $this->productSubTotal($orderDetail),
                            'qty'              => $orderDetail['qty']
                        ]);
                    }
                }else{
                    OrdersDetail::create([
                        'order_id'         => $id,
                        'product_id'       => $orderDetail['product_id'],
                        'discount_type'    => $orderDetail['discount_type'], 
                        'discount_amount'  => $orderDetail['discount'],
                        'product_subtotal' => $this->productSubTotal($orderDetail),
                        'qty'              => $orderDetail['qty']
                    ]);
                }

            }
            
            return response([
                'status' => true,
                'message' => 'Order Update Successfully'
            ]);

        }catch(\Exception $e){
            return $e;
            return response([
                'status' => false,
                'message' => $e->getMessage()
            ]);
        }
        
    }

    public function addPayment(Request $request)
    {
        $order = Order::where('order_id', $request->orderID)->first();
        $paymentTotal = Payment::where('order_id', $request->orderID)->get();
        $due   =   $order->due - $request->formData['payment_total'];
        if($due < 0 ){
            $status = 'return';
        }elseif($due > 0) {
            $status = 'due';
        }else{
            $status = 'paid';
        }
        $order->due    = $due;
        $order->status = $status;
        $order->update();

        try {
            Payment::create([
            'order_id'     => $request->orderID,
            'cust_id'      => $request->custID,
            'amount'       => $request->formData['payment_total'],
            'payment_type' => $request->formData['payment_type'],        
        ]);
            return response([
                'status'  => true,
                'message' => 'Payment Create Successfully'

            ]);
            
        } catch (Exception $e) {

            return response([
                'status'  => false,
                'message' => $e->getMessage()

            ]);
        }
    }

    public function productDelete(Request $request)
    {
        
        OrdersDetail::where('order_id', $request->orderID)
                    ->where('id', $request->product[0]['orderDetail_id'])
                    ->delete();
        return response(['status' => true, 'message' => 'product delete Successfully']);

    }

    public function destroy($id)
    {
        try {
            Order::destroy($id);
            return response([
                'status' => true,
                'message' => "Delete Successfully"
            ]);
        } catch (\Exception $e) {
            return ['status' => false, 'message' => $e->getMessage()];
        }
    }
   
}
