<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Data\Dao\AlarmDao;
use Tymon\JWTAuth\Facades\JWTAuth;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Storage;

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
    
    private function saveAlarm($request, $type ,$idHome, $id = null)
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
        /*if ($authHome = JWTAuth::parseToken()->authenticate())
        {
        }*/
        $alarm = AlarmDao::byId($request->input('alarmId'));
        $image = $this->saveImage($request);
        $detection = AlarmDao::saveDetection($request->input('alarmId'), $request->input('type'), $image);
        $this->notify($alarm, $detection);
        $data = ControllerResponses::createdResp(['detection'=> AlarmDao::getFullDetection($detection->id)]);

        return response()->json($data, $data->code);
    }

    private function notify($alarm, $detection)
    {
        $registrationIds = [];
        $detectionData = AlarmDao::getFullDetection($detection->id);
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
                    "title" => "Alarma Animus",
                    'body' => $this->getDetectionMessage($alarm->habitant->name, $detection->type),
                    "message" => "Que sucede con los animus ???",
                    "detection" => $detectionData
                ],
                "registration_ids" => $registrationIds
            ])]);
            return json_decode($res->getBody());
        }
        return null;
    }

    private function getDetectionMessage($habitantName, $detectionType)
    {
        $text = '';
        switch ($detectionType){
            case 1:
                $text = $habitantName . ' fue detectado en el rango de hora especificado';
                break;
            case 2:
                $text = $habitantName . ' no fue detectado en el rango de hora especificado';
                break;
            case 3:
                $text = 'Se ha detectado un extraño';
                break;
            default:
                $text = 'Notificacion Animus';
                break;
        }
        return $text;
    }

    private function saveImage(Request $request){
        $path = null;
        if($request->file('image'))
        {
            $path = Storage::disk('public')->put('images', $request->file('image'));
        }else if($request->has('image')){
            $file_name = 'image_'.time().'.bmp';
            $path = Storage::disk('public')->put($file_name, base64_decode($request->input('image')));
        }
        return $path;
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
