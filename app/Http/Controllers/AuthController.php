<?php namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use App\Data\Dao\HomeDao;
use App\Util\ValidatorUtil;
use Mail;



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
                    //generar la nueva contraseña de forma aleatoria
                    $length = 10;
                    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
                    $charactersLength = strlen($characters);
                    $randomString = '';
                    for ($i = 0; $i < $length; $i++) {
                        $randomString .= $characters[rand(0, $charactersLength - 1)];
                    }

                    //grabamos la nueva contraseña
                    $home = HomeDao::changePassword($mailHome->id, $randomString);
                    if($home != null){
                        //enviar correo con nueva contraseña 
                         //para pruebas de correo solo para eroman
                        $fromEmail = 'animushabit@gmail.com';
                        $fromName =  'Equipo Animus';
                        $toEmail = $home->email_hogar;
                        $toName = $home->nick_hogar;
                        

                       // Mail::send('Mail.changePassword',["password" => $randomString], function ($message) use($fromEmail,$fromName,$toEmail,$toName) {
                       //     $message->from($fromEmail, $fromName);
                       //     $message->sender($fromEmail, $fromName);
                       //     $message->to($toEmail, $toName);   
                              // $message->cc($fromEmail, $fromName);                               
                              // $message->subject('Nueva contraseña - ANIMUS');
                       // $message->priority(3);
                            //$message->attach('pathToFile');
                        //}); 
                        $mensaje= "Nueva Password";
                        $cabeceras = 'From: webmaster@gmail.com' . "\r\n" .
                                     'Reply-To: animushabit@gmail.com' . "\r\n" .
                                     'X-Mailer: PHP/' . phpversion();


                        mail('eroman@aj.cl','Nueva Password',$mensaje,$cabeceras);

                        $data = ControllerResponses::okResp(['exists'=> 'true']);
                    }
                    
                }else{
                    $data = ControllerResponses::okResp(['exists'=> 'false']);
                }
                
            } 
        }   
        return response()->json($data, $data->code);
    }

}