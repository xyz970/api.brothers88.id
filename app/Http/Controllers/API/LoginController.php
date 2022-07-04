<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Traits\ApiResponse;
use JWTAuth;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Validator;

class LoginController extends Controller
{
    use ApiResponse;
    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        //valid credential
        $validator = Validator::make($credentials, [
            'email' => 'required|email',
            'password' => 'required|string|min:6|max:50'
        ]);

        //Send failed response if request is not valid
        if ($validator->fails()) {
            return $this->internalErrorResponse($validator->messages(),422);
        }

        try {
            if (! $token = JWTAuth::attempt($credentials)) {
                return $this->internalErrorResponse("Cek kembali password atau email anda",);
            }
        } catch (JWTException $e) {
    	return $credentials;
            return $this->internalErrorResponse("Ada yang salah :(");
        }
 	
 		//Token created, return with success response and jwt token
         $data = array(
             'user' => Auth::user(),
            'success' => true,
            'token' => $token,
         );
        return $this->successResponse("Berhasil Login",$data);
    }

    public function logout()
    {
        Auth::logout();
        JWTAuth::parseToken()->invalidate('true');
        return $this->successResponse("Berhasil logout",'');
    }
}
