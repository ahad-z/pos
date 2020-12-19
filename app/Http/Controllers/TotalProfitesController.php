<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\TotalProfites;
use Illuminate\Support\Facades\Validator;

class TotalProfitesController extends Controller
{
    public function index()
    {
        $totalProfits = TotalProfites::all();
        return response([
            'status'  => true,
            'message' => "Data retrieve success!",
            'data'    => $totalProfits
        ]);
    }

    public function create()
    {

    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'amount'  => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => $validator->getMessageBag(),
            ]);
        }
        try {
            TotalProfites::create([
                'amount' => $request->amount,
            ]);
            return response()->json([
                'status' => true,
                'message' => 'TotalProfits Added Successfully',
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
        $totalProfits = TotalProfites::find($id);
        return response([
            'status' => true,
            'TotalProfites' => $totalProfits
        ]);
    }

    public function edit($id)
    {

    }
    public function update(Request $request, $id)
    {
        try{
            $totalProfits = TotalProfites::where('id', $id)->first();
            $totalProfits->amount    = $request->amount;
            $totalProfits->update();
            return response()->json([
                'status'  => true,
                'message' => 'TotalProfits Updated Successfully'
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
            TotalProfites::destroy($id);
            return response([
                'status'  => true,
                'message' => "Delete Successfully"
            ]);
        } catch (\Exception $e) {
            return ['status' => false, 'message' => $e->getMessage()];
        }
    }
}
