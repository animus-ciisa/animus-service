<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Data\Dao\HabitantDao;
use App\Util\ValidatorUtil;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;


class HabitantController extends Controller
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

            $validate = \Validator::make($request->all(),[
                'type' => 'required',
                'name' => 'required',
                'lastname' => 'required',
                'birthday' => 'required',
            ]);

            if($validate->fails()){
                $data = ControllerResponses::unprocesableResp($validate->errors());
            }else
            {
                $habitant = HabitantDao::save($authHome->id,
                    $request->input('type'), $request->input('name'),
                    $request->input('lastname'), $request->input('birthday'));
                if($habitant != null){
                    $data = ControllerResponses::createdResp(['id'=> $habitant->id]);
                }
            }
        }
        return response()->json($data, $data->code);
    }
}
