<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Data\Dao\AlarmDao;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;


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
