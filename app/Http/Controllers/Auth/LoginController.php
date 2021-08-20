<?php
namespace App\Http\Controllers\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Session;

class LoginController extends Controller
{
        public function index()
        {
            return 'Done';

        }
        public function authLogin(Request $request)
        {
            $validator = Validator::make($request->all(), [
                'email'  => 'required',
                'password'  => 'required',
            ]);
            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => $validator->getMessageBag(),
                ]);
            }
            try {
                $user = User::whereEmail($request->email)->first();
                if($user){
                    if (\Hash::check($request->password, $user->password)){
                        $token = \Str::random(60);
                        $user->forceFill([
                            'api_token' => hash('sha256', $token),
                        ])->save();
                        return response([
                            'status' => true,
                            'message' => 'Login successfully!',
                            'access_token' => $token,
                            'data' => $user,
                        ]);
                    }else{
                        return response([
                            'status' => false,
                            'message'=> 'Credential not match'
                        ]);
                    }
                }else{
                    return response([
                        'status' => false,
                        'message'=> 'Credential not match'
                    ]);
                }

            }catch (\Exception $e){
                return  response([
                   'status' => false,
                   'message' => $e->getMessage()
                ]);
            }
        }
        public function authLogOut(Request $request)
        {
            $request->user()->forceFill([
                'api_token' => null,
            ])->save();

            Session::flush();
            return response()->json([
                'status' => true
            ]);
        }
}
