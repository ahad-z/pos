<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Stock;
use Illuminate\Support\Facades\Validator;

class StockController extends Controller
{
    public function index()
    {
        $stocks = Stock::with('products')->get();
        return response([
            'status'  => true,
            'message' => "Data retrieve success!",
            'data'    => $stocks
        ]);
    }

    public function create()
    {

    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'product_id'  => 'required',
            'quantity'      => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => $validator->getMessageBag(),
            ]);
        }
        try {
            Stock::create([
                'product_id' => $request->product_id,
                'quantity'     => $request->quantity,
            ]);
            return response()->json([
                'status' => true,
                'message' => 'Stock Added Successfully',
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
        $stock = Stock::find($id);
        return response([
            'status' => true,
            'Stock' => $stock
        ]);
    }

    public function edit($id)
    {

    }
    public function update(Request $request, $id)
    {
        try{
            $stock = Stock::where('stocks_id', $id)->first();
            $stock->product_id  = $request->product_id;
            $stock->quantity    = $request->quantity;
            $stock->update();
            return response()->json([
                'status'  => true,
                'message' => 'Stock Updated Successfully'
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
            Stock::destroy($id);
            return response([
                'status'  => true,
                'message' => "Delete Successfully"
            ]);
        } catch (\Exception $e) {
            return ['status' => false, 'message' => $e->getMessage()];
        }
    }

    public function allStockDelete(Request $request)
    {
        try{
            Stock::destroy($request->id);
            return response([
                'status' => true,
                'message' => "Brand delete Successfully",
                 'total'=> count($request->id)
            ]);
        }catch(\Exception $e){
            return ['status' => false, 'message' => $e->getMessage()];
        }
    }

}
