<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Unit;

class UnitController extends Controller
{
    
    public function index()
    {
        $units = Unit::all();
        return response([
            'status'  => true,
            'message' => "Data retrieve success!",
            'data'    => $units
        ]);
    }
    public function create()
    {

    }

    public function store(Request $request)
    {
        
        $validator = Validator::make($request->all(), [
            'UnitName'  => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => $validator->getMessageBag(),
            ]);
        }
        try {
            Unit::create([
                  'unit' => $request->UnitName
             ]);
            return response()->json([
                'status' => true,
                'message' => 'Unit Added Successfully',
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
        $unit = Unit::find($id);
        return response([
            'status' => true,
            'unit' => $unit
        ]);
    }

    public function edit($id)
    {

    }
    public function update(Request $request, $id)
    {

        try{
            $unit = Unit::where('unit_id', $id)->first();
            $unit->unit  = $request->UnitName;
            $unit->update();
            return response()->json([
                'status'  => true,
                'message' => 'Unit Updated Successfully'
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
            Unit::destroy($id);
            return response([
                'status' => true,
                'message' => "Unit delete Successfully"
            ]);
        } catch (\Exception $e) {
            return ['status' => false, 'message' => $e->getMessage()];
        }
    }

    public function allDelete(Request $request)
    {
        
        try{
            Unit::destroy($request->id);
            return response([
                'status' => true,
                'message' => "Unit delete Successfully",
                 'total'=> count($request->id)
            ]);
        }catch(\Exception $e){
            return ['status' => false, 'message' => $e->getMessage()];
        }
    }
}
