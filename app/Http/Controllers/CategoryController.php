<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Category;

class CategoryController extends Controller
{
    public function index()
    {
        $Categories = Category::all();
        return response([
            'status'  => true,
            'message' => "Data retrieve success!",
            'data'    => $Categories
        ]);
    }
    public function create()
    {

    }

    public function store(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'categoryName'  => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => $validator->getMessageBag(),
            ]);
        }
        try {
            Category::create([
                'category_name' => $request->categoryName,
            ]);
            return response()->json([
                'status' => true,
                'message' => 'Category Added Successfully',
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
        $categories = Category::find($id);
        return response([
            'status' => true,
            'Category' => $categories
        ]);
    }

    public function edit($id)
    {

    }
    public function update(Request $request, $id)
    {

        try{
            $category = Category::where('cat_id', $id)->first();
            $category->category_name  = $request->categoryName;
            $category->update();
            return response()->json([
                'status'  => true,
                'message' => 'Category Updated Successfully'
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
            Category::destroy($id);
            return response([
                'status' => true,
                'message' => "Delete Successfully"
            ]);
        } catch (\Exception $e) {
            return ['status' => false, 'message' => $e->getMessage()];
        }
    }

    public function batchDelete(Request $request)
    {
        
        try{
            Category::destroy($request->id);
            return response([
                'status' => true,
                'message' => "Category delete Successfully",
                'total'=> count($request->id)
            ]);
        }catch(\Exception $e){
            return ['status' => false, 'message' => $e->getMessage()];
        }
    }

}
