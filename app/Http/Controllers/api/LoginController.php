<?php

// namespace App\Http\Controllers\api;

// use App\Http\Controllers\Controller;
// use Illuminate\Http\Request;
// use Illuminate\Support\Facades\Validator;

// class LoginController extends Controller
// {
//     /**
//      * Handle the incoming request.
//      *
//      * @param  \Illuminate\Http\Request  $request
//      * @return \Illuminate\Http\Response
//      */
//     public function __invoke(Request $request)
//     {
//         $validator = Validator::make($request->all(),[
//             'email'=> 'required',
//             'password'=>'required'
//         ]);

//         if($validator->fails()){
//             return response()->json($validator->errors(), 422);
//         }

//         //get credientials from request
//         $credentials = $request->only('email','password');
        

//         //if auth faild

//         if(!$token = auth()-> guard('api')->attempt($credentials)){
//             return response()->json([
//                 'success'=>false,
//                 'message'=> 'Email atau password anda salah'
//             ], 401);
//         }
//         return response()->json([
//             'success'=> true,
//             'user'=> auth()->guard('api')->user(),
//             'token'=> $token
//         ],200);
//     }
// }
namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
Use App\Models\User;


class LoginController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        //set validation
        $validator = Validator::make($request->all(), [
            'email'     => 'required',
            'password'  => 'required'
        ]);

        //if validation fails
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        //get credentials from request
        $credentials = $request->only('email', 'password');
        

        //if auth failed
        if(!$token = auth()->guard('api')->attempt($credentials)) {
            return response()->json([
                'success' => false,
                'message' => 'Email atau Password Anda salah'
            ], 401);
        }


        //if auth success
        //perintah update tabel user untuk update remember_token berisi $token
        $post = User::where('email',$request->email)->update([
            'remember_token'=> $token,
        ]);
        if ($post) {
            return response()->json([
                'success' => true,
                'user'    => auth()->guard('api')->user(),    
                'token'   => $token   
            ], 200);
        }else{
            return response()->json([
                'success'=>false,
                'message'=> 'gagal login!',

            ], 401);
        }
        
    }

}