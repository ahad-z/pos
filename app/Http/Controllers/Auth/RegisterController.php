<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
class RegisterController extends Controller
{
    public function index()
    {
        return 'Done';

    }
    public function store(Request $request)
    {
    	$validator = Validator::make($request->all(), [
    		'name'  => 'required',
            'email'  => 'required|email',
            'password'  => 'required',
            'confirmPassword'  => 'required|same:password',
        ]);

         if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => $validator->getMessageBag(),
            ]);
        }
        
        try{
            User::create(array_merge(
            	$request->except('password','confirmPassword'),
            	[
            		'password' => bcrypt($request->password)
            	]
            ));
             return response([
                'status' => true,
                'message'=>'Staffs added successfully!'
            ]);
           
        }catch(\Exception $e){
            return response([
                'status' => false,
                'message'=>$e->getMessage()
            ]);
        }
    }
}
