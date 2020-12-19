<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use  App\Models\User;

class UserController extends Controller
{
    public function index()
    {
        $users = User::all();
        return response([
            'status'  => true,
            'message' => "Data retrieve success!",
            'data'    => $users
        ]);
    }
    public function create()
    {

    }
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name'  => 'required',
            'email'  => 'required',
            'password'  => 'required',
            'c_password'  => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => $validator->getMessageBag(),
            ]);
        }
        try {
            User::create(array_merge(
                $request->except('password', 'c_password'),
                [
                    'password' => bcrypt($request->password)
                ]
            ));
            return response()->json([
                'status' => true,
                'message' => 'User Added Successfully',
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
        $user = User::find($id);
        return response([
            'status' => true,
            'User' => $user
        ]);
    }

    public function edit($id)
    {

    }
    public function update(Request $request, $id)
    {

        try{
            $user = User::where('id', $id)->first();
            $user->name  = $request->name;
            $user->email  = $request->email;
            $user->update();
            return response()->json([
                'status'  => true,
                'message' => 'User Updated Successfully'
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
            User::destroy($id);
            return response([
                'status' => true,
                'message' => "Delete Successfully"
            ]);
        } catch (\Exception $e) {
            return ['status' => false, 'message' => $e->getMessage()];
        }
    }
}
