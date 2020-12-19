<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Expenses;

class ExpensesController extends Controller
{
     public function index()
    {
        $expense = Expenses::all();
        return response([
            'status'  => true,
            'message' => "Data retrieve success!",
            'data'    => $expense
        ]);
    }
    public function create()
    {

    }

    public function store(Request $request)
    {
      
        $validator = Validator::make($request->all(), [
            'type'  => 'required',
            'amount'  => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => $validator->getMessageBag(),
            ]);
        }

        if(!is_numeric($request->amount)){
            return response()->json([
                'status' => false,
                'message' => 'Please Amount price must be an number'
            ]);
        }

        try {
            Expenses::create([
                  'type' => $request->type,
                  'amount' => $request->amount,
             ]);
            return response()->json([
                'status' => true,
                'message' => 'Expense Added Successfully',
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
        $expense = Expenses::find($id);
        return response([
            'status' => true,
            'expense' => $expense
        ]);
    }

    public function edit($id)
    {

    }
    public function update(Request $request, $id)
    {
        try{
            $expense = Expenses::where('id', $id)->first();
            $expense->type  = $request->type;
            $expense->amount  = $request->amount;
            $expense->update();
            return response()->json([
                'status'  => true,
                'message' => 'Expense Updated Successfully'
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
            Expenses::destroy($id);
            return response([
                'status' => true,
                'message' => "Expenses delete Successfully"
            ]);
        } catch (\Exception $e) {
            return ['status' => false, 'message' => $e->getMessage()];
        }
    }

    public function allExpensesDelete(Request $request)
    {
        try{
            Expenses::destroy($request->id);
            return response([
                'status' => true,
                'message' => "Expenses delete Successfully",
                 'total'=> count($request->id)
            ]);
        }catch(\Exception $e){
            return ['status' => false, 'message' => $e->getMessage()];
        }
    }
}
