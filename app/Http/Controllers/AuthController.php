<?php namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;

class AuthController extends Controller 
{

    public function renew(Request $request)
    {
        $token = JWTAuth::getToken();
        $newToken = JWTAuth::refresh($token);
        $data = ControllerResponses::okResp(['token' => $newToken]);
        return response()->json($data, $data->code);
    }

}