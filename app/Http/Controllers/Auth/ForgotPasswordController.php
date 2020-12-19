<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use App\Mail\ForgetPasswordMail;
use Illuminate\Support\Facades\Mail;
use App\Jobs\UserEmailSend;

class ForgotPasswordController extends Controller
{
    public function index()
    {
        return 'Done';
    }
     public function forgotPassword(Request $request)
     {

     	try{
     		$user  = User::whereEmail($request->email)->first();

         	if($user){
         		$verURL = \URL::temporarySignedRoute(
    			    'verifyLoginEmail', now()->addMinutes(5), ['email' => $request->email]
    		    );
                /* If i want send mail to all user */
               /* foreach (User::all() as $user) {
                    UserEmailSend::dispatch($verURL, $user->email);
                }*/
                UserEmailSend::dispatch($verURL, $user->email);
    		    return response([
    		    	'status' => true,
    		    	'message'=> 'We will send verification link your mail within short time'
    		    ]);
         	}else{
         		return response([
    		    	'status' => false,
    		    	'message'=> 'Email not Found!'
    		    ]);
         	}

     	}catch(\Exception $e){
            return $e;
     		/*return response([
     			'status'  => false,
     			'message' => $e
     		]);*/

     	}
     	
     }
     public function updatePassword(Request $request)
     {
        $validator = Validator::make($request->all(), [
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
            $user = User::whereEmail($request->email)->first();
            if($user){
                $user->password = bcrypt($request->password);
            $user->update();
             return response([
                'status' => true,
                'message'=>'password updated successfully!'
            ]);
            }else{
                return response([
                'status' => false,
                'message'=>'Email not Found!'
            ]);
            }
            
        }catch(\Exception $e){
            return response([
                'status' => false,
                'message'=>$e->getMessage()

            ]);
        }

     }
}
