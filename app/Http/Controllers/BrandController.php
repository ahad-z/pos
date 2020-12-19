<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Brand;

class BrandController extends Controller
{
    public function index(Request $request)
    {
        $brands = new Brand();
        if(isset($request->searchKey)){
            $brands = $brands->where('brand_name', 'LIKE', '%' . $request->get('searchKey') . '%');
        }
        $brands = $brands->get();
        return response([
            'status'  => true,
            'message' => "Data retrieve success!",
            'data'    => $brands
        ]);
    }
    public function create()
    {

    }

    public function store(Request $request)
    {
        
        $validator = Validator::make($request->all(), [
            'brandName'  => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => $validator->getMessageBag(),
            ]);
        }
        try {
            Brand::create([
                  'brand_name' => $request->brandName
             ]);
            return response()->json([
                'status' => true,
                'message' => 'Brand Added Successfully',
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
        $brand = Brand::find($id);
        return response([
            'status' => true,
            'brand' => $brand
        ]);
    }

    public function edit($id)
    {

    }
    public function update(Request $request, $id)
    {
        try{
            $brand = Brand::where('brand_id', $id)->first();
            $brand->brand_name  = $request->brandName;
            $brand->update();
            return response()->json([
                'status'  => true,
                'message' => 'Brand Updated Successfully'
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
            Brand::destroy($id);
            return response([
                'status' => true,
                'message' => "Brand delete Successfully"
            ]);
        } catch (\Exception $e) {
            return ['status' => false, 'message' => $e->getMessage()];
        }
    }

    public function batchDelete(Request $request)
    {
        try{
            Brand::destroy($request->id);
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
