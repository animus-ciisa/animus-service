<?php namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Data\Dao\UserDao;
use App\Data\Dao\HomeDao;
use App\Util\GeneratorUtil;
use App\Data\Dao\HabitantDao;
use Config;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;

class UserController extends Controller
{

    public function __construct()
    {
        Config::set('jwt.user', 'App\Data\Entities\UserEntity');
        Config::set('auth.providers.users.model', \App\Data\Entities\UserEntity::class);
    }

    public function store(Request $request)
    {
        $response = ControllerResponses::badRequestResp();
        if($this->validateUserRequest($request->all())){

            if(!$habitant = HabitantDao::byId($request->input('idHabitant'))){
                $response = ControllerResponses::unprocesableResp(['Habitante no existe']);
            }else{
                $password = GeneratorUtil::aleatoryPassword();
                $user = UserDao::save($habitant->id, $request->input('imei'), $request->input('device'), $password, $request->input('fcmToken'));
                if($user){
                    $credentials = ['imei_usuario' => $request->input('imei'), 'password' => $password];
                    $token = JWTAuth::attempt($credentials);
                    $user->load('habitant');
                    $user['access'] = ['token' => $password];
                    $user['session'] = ['token'=> $token];
                    $response = ControllerResponses::createdResp($user);
                }
                else
                    $response = ControllerResponses::internalServerErrorResp();
            }
        }
        return response()->json($response, $response->code);
    }


    public function authenticate(Request $request)
    {
        $response = ControllerResponses::badRequestResp();
        if($this->validateAuthenticateRequest($request->all())){
            try {
                $credentials = ['imei_usuario' => $request->input('imei'), 'password' => $request->input('serial')];
                if ($token = JWTAuth::attempt($credentials)) {
                    $user = UserDao::getByImei($request->input('imei'));
                    $user['session'] = ['token' => $token ];
                    $response = ControllerResponses::okResp($user);
                }else{
                    $response = ControllerResponses::unprocesableResp('Usuario o password incorrecto');
                }
            } catch (JWTException $e) {
                $response = ControllerResponses::unprocesableResp('No se pudo crear el token');
            }
        }
        return response()->json($response, $response->code);
    }

    public function myHome()
    {
        $response = ControllerResponses::badRequestResp();
        if ($authUser = JWTAuth::parseToken()->authenticate()) {
            $user = UserDao::getByImei($authUser->imei);
            $homeData = HomeDao::allHomeData($user->habitant->idHogar);
            $response = ControllerResponses::okResp($homeData);
        }
        return response()->json($response, $response->code);
    }

    public function renew(Request $request)
    {
        $token = JWTAuth::getToken();
        $newToken = JWTAuth::refresh($token);
        $data = ControllerResponses::okResp(['token' => $newToken]);
        return response()->json($data, $data->code);
    }

    private function validateAuthenticateRequest($auth){
        $validate = \Validator::make($auth,[
            'imei' => 'required',
            'serial' => 'required',
        ]);
        return !$validate->fails();
    }

    private function validateUserRequest($user){
        $validate = \Validator::make($user,[
            'idHabitant' => 'required',
            'imei' => 'required',
            'device' => 'required',
            'fcmToken' => 'required'
        ]);
        return !$validate->fails();
    }
}