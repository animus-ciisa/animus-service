<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Data\Dao\AlarmDao;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use GuzzleHttp\Client;


class AlarmInTimeRangeController extends Controller
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
        if ($authHome = JWTAuth::parseToken()->authenticate()) {
            
            if($this->validateAlarm($request->all()))
            {
                
                $alarm = $this->saveAlarm($request, 1,$authHome->id);
                if($alarm != null){
                    $data = ControllerResponses::createdResp(['id'=> $alarm->id]);
                }
            }else
            {
                $data = ControllerResponses::unprocesableResp();
            }
        }
        return response()->json($data, $data->code);
    }

    public function update($id,Request $request)
    {
        $data = ControllerResponses::badRequestResp();
        if ($authHome = JWTAuth::parseToken()->authenticate()) {
            
            if($this->validateAlarm($request->all()))
            {
                
                $alarm = $this->saveAlarm($request, 1,$authHome->id,$id);
                if($alarm != null){
                    $data = ControllerResponses::createdResp(['id'=> $alarm->id]);
                }
            }else
            {
                $data = ControllerResponses::unprocesableResp();
            }
        }
        return response()->json($data, $data->code);

    }
    
    private function saveAlarm($request, $type,$idHome, $id = null)
    {
            $alarm = AlarmDao::save($idHome,
            $type, $request->input('idPerson'),
            $request->input('startHour'), $request->input('endHour'),
            $request->input('monday'),$request->input('tuesday'),
            $request->input('wednesday'),$request->input('thursday'),
            $request->input('friday'),$request->input('saturday'),
            $request->input('sunday'),$request->input('status'),
            $id
        );
        return $alarm;
    }
    
    public function destroy($id, Request  $request)
    {
        if ($authHome = JWTAuth::parseToken()->authenticate()) 
        { 
            $alarm = AlarmDao::delete($id);

            $data = ControllerResponses::okResp(['status'=> 'true']);
        }        
        return response()->json($data, $data->code);
    }

    public function detection(Request $request)
    {
        $data = ControllerResponses::badRequestResp();
        //if ($authHome = JWTAuth::parseToken()->authenticate())
        //{
        $detection = AlarmDao::saveDetection($request->input('idAlarm'), $request->input('hasDetection'));
        if($request->has('idHabitant')){
            $image = $this->saveImage($request, $request->input('idHabitant'));
            if($image){
                AlarmDao::saveDetectionImage($detection->id, $image->id);
            }
        }

        $data = ControllerResponses::createdResp(['notify' => $this->notify($detection->id)]);
        //}
        return response()->json($data, $data->code);
    }

    private function validataDetection()
    {

    }

    private function notify($detection)
    {
        $registrationIds = [];
        $detectionData = AlarmDao::getFullDetection($detection);
        if($detectionData != null){
            foreach ($detectionData->alarm->home->habitants as $habitant){
                if($habitant->user != null){
                    $registrationIds[] = $habitant->user->fcmToken;
                }
            }
        }

        if(count($registrationIds) > 0){
            $client = new Client(['headers' => [
                'Authorization' => 'key=AIzaSyD004GHyZqw75enxwCJHbhUUEHOFgaiQZw',
                'content-type' => 'application/json'
            ]]);
            $res = $client->post('https://fcm.googleapis.com/fcm/send', ['body' => json_encode([
                "data" => [
                    "title" => "Nueva de tección de Animus",
                    'body' => "La alarma se a detonado entera de brigida",
                    "message" => "Que sucede con los animus ???"
                ],
                "registration_ids" => $registrationIds
            ])]);
            return json_decode($res->getBody());
        }
        return null;
    }

    private function saveImage(Request $request, $idHabitant, $id = null){
        if($request->file('image'))
        {
            $path = Storage::disk('public')->put('images', $request->file('image'));
            $nameImagen = $request->file('image')->getClientOriginalName();
        }
        $image = ImageDao::save($idHabitant, $path, $nameImagen,
            $request->input('yRectangle'), $request->input('xRectangle'), $request->input('hRectangle'),
            $request->input('wRectangle'), $request->input('type'), $id);
        return $image;
    }

    private function validateAlarm($data)
    {
        $validate = \Validator::make($data,[
            'idPerson' => 'required',
            'startHour' => 'required',
            'endHour' => 'required',
            'status' => 'required',   
        ]);
        return !$validate->fails();
    }
}
