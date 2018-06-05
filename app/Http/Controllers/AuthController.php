<?php namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use App\Data\Dao\HomeDao;
use App\Util\ValidatorUtil;



class AuthController extends Controller 
{

    public function renew(Request $request)
    {  
      
        $token = JWTAuth::getToken();
        $newToken = JWTAuth::refresh($token);
        $data = ControllerResponses::okResp(['token' => $newToken]);
        return response()->json($data, $data->code);
    }

    public function authenticate(Request $request)
    {
        

        $data = ControllerResponses::badRequestResp();
        $validate = \Validator::make($request->all(),[
            'email' => 'required',
            'password' => 'required',
        ]);
      

        if($validate->fails()){
            $data = ControllerResponses::unprocesableResp($validate->errors());
        }else
        {      
                try {
                    $credentials = ['email_hogar' => $request->input('email'), 'password' => $request->input('password')];
                    if ($token = JWTAuth::attempt($credentials)) {    
                        $login = HomeDao::getByEmail($request->input('email'));                                                               
                        $login['session'] = ['token' => $token ];
                        $data = ControllerResponses::createdResp($login);
                      
                    }else{
                        $data = ControllerResponses::unprocesableResp('Usuario o password incorrecto');
                    }
                } catch (JWTException $e) {
                    $data = ControllerResponses::unprocesableResp('No se pudo crear el token');
                }     
            
        }

        return response()->json($data,$data->code);
    }

}