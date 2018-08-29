<?php namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use App\Data\Dao\HomeDao;
use App\Util\ValidatorUtil;
use App\Util\GeneratorUtil;
use Mail;
use QrCode;
use Intervention\Image\Facades\Image;

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
                    $data = ControllerResponses::okResp($login);
                    
                }else{
                    $data = ControllerResponses::unprocesableResp('Usuario o password incorrecto');
                }
            } catch (JWTException $e) {
                $data = ControllerResponses::unprocesableResp('No se pudo crear el token');
            }        
        }
        return response()->json($data,$data->code);
    }

    public function recoverPassword(Request $request)
    {
        $data = ControllerResponses::badRequestResp();
        if($request->has("email"))
        {
            $mail = validatorUtil::checkMail($request->input('email'));
            if($mail != null)
            {
                $mailHome = HomeDao::getByEmail($request->input('email'));
                if ($mailHome)
                {
                    $newPassword = GeneratorUtil::aleatoryPassword();
//https://laracasts.com/discuss/channels/laravel/laravel-mail-not-working-and-php-function-mail-does
                    //grabamos la nueva contraseña
                    $home = HomeDao::changePassword($mailHome->id, $newPassword);
                    if($home != null){
                        //enviar correo con nueva contraseña 
                         //para pruebas de correo solo para eroman
                        $fromEmail = 'animushabit@gmail.com';
                        $fromName =  'Equipo Animus';
                        $toEmail = $home->email_hogar;
                        $toName = $home->nick_hogar;
                        
                        Mail::send('Mail.changePassword',["password" => $newPassword], function ($message) use($fromEmail,$fromName,$toEmail,$toName) {
                            $message->from($fromEmail, $fromName);
                            $message->sender($fromEmail, $fromName);
                            $message->to($toEmail, $toName);   
                            $message->subject('Nueva contraseña - ANIMUS');
                        }); 
                        $data = ControllerResponses::okResp(['status'=> 'true']);
                    }
                    
                }else{
                    $data = ControllerResponses::okResp(['status'=> 'false']);
                }
            } 
        }   
        return response()->json($data, $data->code);
    }

    public function qrGenerate($habitantId)
    {
        header("Content-Type: image/png");
        $qrText = json_encode(['habitantId' => $habitantId]);
        return QrCode::format('png')->size(200)->generate($qrText);
        /*if ($authHome = JWTAuth::parseToken()->authenticate())
        {
            $qrText = json_encode(['habitantId' => $habitantId]);
            return QrCode::format('png')->size(200)->generate($qrText);
        }*/
    }

}