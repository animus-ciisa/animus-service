<?php namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Data\Dao\CameraDao;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;


class CameraController extends Controller
{
    public function store(Request $request)
    {
        $response = ControllerResponses::notFoundResp();
        if ($authHome = JWTAuth::parseToken()->authenticate()) {
            $cameras = $request->input('cameras');
            if(is_array($cameras)){
                $notSaved = 0;
                $savedArray = [];
                for($i = 0; $i < count($cameras); $i++){
                    if($this->validateCameraRequest($cameras[$i])){
                        $camera = CameraDao::save($authHome->id, $cameras[$i]['name'], $cameras[$i]['status'], $cameras[$i]['associate']);
                        if($camera){
                            $savedArray[] = $camera;
                        }else{
                            $notSaved++;
                        }
                    }else{
                        $notSaved++;
                    }
                }
                if($notSaved > 0){
                    for($i = 0; $i < count($savedArray); $i++){
                        CameraDao::delete($savedArray[$i]->id);
                    }
                    $response = ControllerResponses::unprocesableResp('Uno o varios elementos no son válidos');
                }else{
                    $response = ControllerResponses::createdResp($savedArray);
                }
            }
        }
        return response()->json($response, $response->code);
    }

    private function validateCameraRequest($camera){
        $validate = \Validator::make($camera,[
            'name' => 'required',
            'status' => 'required',
            'associate' => 'required',
        ]);
        return !$validate->fails();
    }
}