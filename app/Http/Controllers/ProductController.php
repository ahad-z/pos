<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Product;
use DB;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $products = Product::with('brands','categories','units', 'stock');

        if($request->brand_id){
            $products->whereHas('brands', function($q) use($request){
                $q->where('brand_id', $request->brand_id);
            });
        }

        if($request->cat_id) {
            $products->whereHas('categories', function($q) use($request) {
                $q->where('cat_id', $request->cat_id);
            });
        }

        return response([
            'status'  => true,
            'message' => "Data retrieve success!",
            'data'    => $products->get()
        ]);
    }
    
    public function create()
    {

    }

    public function store(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'product_name'  => 'required',
            'brand_id'      => 'required',
            'cat_id'        => 'required',
            'unit_id'       => 'required',
            'buying_price'  => 'required',
            'selling_price' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => $validator->getMessageBag(),
            ]);
        }
        if(!is_numeric($request->buying_price)){
            return response()->json([
                'status' => false,
                'message' => 'Please Buying price must be an number'
            ]);
        }else if(!is_numeric($request->selling_price)){
            return response()->json([
                'status' => false,
                'message' => 'Please Selling price must be an number'
            ]);
        }
        try {
            Product::create([
                'product_name' => $request->product_name,
                'brand_id'     => $request->brand_id,
                'cat_id'       => $request->cat_id,
                'unit_id'      => $request->unit_id,
                'buying_price' => $request->buying_price,
                'selling_price'=> $request->selling_price,
            ]);
            return response()->json([
                'status' => true,
                'message' => 'Product Added Successfully',
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
        $product = Product::find($id);
        return response([
            'status' => true,
            'Product' => $product
        ]);
    }

    public function edit($id)
    {

    }

    public function update(Request $request, $id)
    {

        try{
            $product = Product::where('product_id', $id)->first();
            $product->product_name  = $request->product_name;
            $product->brand_id      = $request->brand_id;
            $product->cat_id        = $request->cat_id;
            $product->unit_id       = $request->unit_id;
            $product->buying_price  = $request->buying_price;
            $product->selling_price = $request->selling_price;
            $product->update();
            return response()->json([
                'status'  => true,
                'message' => 'Product Updated Successfully'
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
            Product::destroy($id);
            return response([
                'status'  => true,
                'message' => "Delete Successfully"
            ]);
        } catch (\Exception $e) {
            return ['status' => false, 'message' => $e->getMessage()];
        }
    }

    public function productsAllDelete(Request $request)
    {
         try{
            Product::destroy($request->id);
            return response([
                'status' => true,
                'message' => "Product delete Successfully",
                 'total'=> count($request->id)
            ]);
        }catch(\Exception $e){
            return ['status' => false, 'message' => $e->getMessage()];
        }
    }
}
