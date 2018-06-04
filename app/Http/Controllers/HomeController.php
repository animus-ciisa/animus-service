<?php namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Data\Dao\HomeDao;
use App\Util\ValidatorUtil;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;


class HomeController extends Controller
{
    public function index()
    {
        $data = ControllerResponses::okResp();
        return response()->json($data, $data->code);
    }

    public function show($id)
    {
        $data = ControllerResponses::okResp();
        return response()->json($data, $data->code);
    }


    public function store(Request $request)
    {
        $data = ControllerResponses::badRequestResp();
        $validate = \Validator::make($request->all(),[
            'nick' => 'required|min:5',
            'email' => 'required',
            'password' => 'required',
        ]);
        if($validate->fails()){
            $data = ControllerResponses::unprocesableResp($validate->errors());
        }else{
            $home = HomeDao::save($request->input('nick'), $request->input('email'), $request->input('password'), null);
            if($home != null){
                $data = ControllerResponses::createdResp($home);
                try {
                    $credentials = ['email_hogar' => $request->input('email'), 'password' => $request->input('password')];
                    if ($token = JWTAuth::attempt($credentials)) {
                        $home['session'] = ['token' => $token ];
                        $data = ControllerResponses::createdResp($home);
                    }
                } catch (JWTException $e) {
                    $data = ControllerResponses::unprocesableResp('No se pudo crear el token');
                }
            }else{
                $data = ControllerResponses::unprocesableResp('Error al intentar crear el hogar');
            }
        }
        return response()->json($data, $data->code);
    }

    public function update($id, Request  $request)
    {
        $data = ControllerResponses::okResp();
        return response()->json($data, $data->code);
    }


     public function destroy($id, Request  $request)
    {
        $data = ControllerResponses::okResp();
        return response()->json($data, $data->code);
    }

    public function validateMail(Request $request)
    {
        $data = ControllerResponses::badRequestResp();
        if($request->has("email"))
        {
            $mail = validatorUtil::checkMail($request->input('email'));
            if($mail != null)
            {
                $mailHome = HomeDao::getByEmail($request->input('email'));
                $data = ControllerResponses::okResp(['exists'=> ($mailHome != null) ]);
            } 
        }   
        return response()->json($data, $data->code);
    }

    public function validateLogin(Request $request)
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
            $login = HomeDao::getByLogin($request->input('email'), $request->input('password'));
        }

    }
}