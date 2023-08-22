<?php

namespace App\Http\Controllers\api;


use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use PHPOpenSourceSaver\JWTAuth\Facades\JWTAuth;
use PHPOpenSourceSaver\JWTAuth\Exceptions\JWTException;
use PHPOpenSourceSaver\JWTAuth\Exceptions\TokenExpiredException;
use PHPOpenSourceSaver\JWTAuth\Exceptions\TokenInvalidException;
use Illuminate\Support\Facades\Validator;
Use App\Models\User;



class LogoutController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        //remove token
        // $removeToken = JWTAuth::invalidate(JWTAuth::getToken());

        // if($removeToken) {
        //     return response()->json([

        //         'success'=>true,
        //         'message'=> 'Logout Berhasil!',
        //     ]);
        //     }

        $validator = Validator::make($request->all(), [
            'email'     => 'required'
        ]);

        //if validation fails
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        //get credentials from request
        $credentials = $request->only('email');

        $removeToken = JWTAuth::invalidate(JWTAuth::getToken());

        if($removeToken) {
            //return response JSON
            //perintah hapus token di users
            $post = User::where('email',$request->email)->update(
                [ 'remember_token' => null ]
            );

            if($post){
                return response()->json([
                    'success' => true,
                    'message' => 'Logout Berhasil!',  
                ]);
            } else {
                return response()->json([
                    'success'=>false,
                    'message'=> 'gagal logout!',
    
                ], 401);
            }

            
        }
    }
}
