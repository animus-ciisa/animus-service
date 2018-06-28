<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Data\Dao\HabitantDao;
use App\Data\Dao\ImageDao;
use App\Util\ValidatorUtil;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Illuminate\Support\Facades\Storage;


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
                
                $habitant = HabitantDao::save($authHome->id,$request->input('type'),$request->input('name'), $request->input('lastname'), $request->input('birthday'), null);
                $data = ControllerResponses::okResp(['Id'=> $habitant->id]);
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

    public function update($id,Request $request)
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
                
                $habitant = HabitantDao::save($authHome->id,$request->input('type'),$request->input('name'), $request->input('lastname'), $request->input('birthday'), $id);
               
                $habitant = HabitantDao::save($authHome->id,$request->input('type'),$request->input('name'),
                    $request->input('lastname'), $request->input('birthday'), $id);
                if($habitant != null)
                {
                   $data = ControllerResponses::okResp(['status'=> 'true']);
                }
            }
        }
        return response()->json($data, $data->code);
    }

    
    public function destroy($id, Request  $request)
    {
        if ($authHome = JWTAuth::parseToken()->authenticate()) 
        { 
            $habitant = HabitantDao::delete($id);

            $data = ControllerResponses::okResp(['status'=> 'true']);
        }        
        return response()->json($data, $data->code);
    }



    public function storeImage($idHabitant, Request $request)
    {
        $data = ControllerResponses::badRequestResp();
        if ($authHome = JWTAuth::parseToken()->authenticate()) 
        { 
            $validate = \Validator::make($request->all(),[                
                'image' => 'required',
                'yRectangle' => 'required',
                'xRectangle' => 'required',
                'hRectangle' => 'required',
                'wRectangle' => 'required',
                'type' => 'required',

            ]);

            if($validate->fails()){
                $data = ControllerResponses::unprocesableResp($validate->errors());
            }else
            {
             
                if($request->file('image'))
                {
                  
                    $path = Storage::disk('public')->put('images',$request->file('image'));
                    $pathf = asset($path);
                    $nameImagen = $request->file('image')->getClientOriginalName();
                }


                $image = ImageDao::save($idHabitant,$path, $nameImagen, $request->input('yRectangle'),$request->input('xRectangle'),$request->input('hRectangle'),$request->input('wRectangle'),$request->input('type') ,null);
                $data = ControllerResponses::okResp(['id'=> $image->id,'path' => $pathf]);
        {
            if($this->validateImageRequest($request->all()))
            {
                $image = $this->saveImage($request, $idHabitant);
                if($image){
                    $data = ControllerResponses::okResp(['id'=> $image->id,'path' => asset($image->path)]);
                }
            }
        }
        return response()->json($data, $data->code);
        }
      }
    }
    public function updateImage(Request $request, $idHabitant, $idImage)
    {
        $data = ControllerResponses::badRequestResp();
        if ($authHome = JWTAuth::parseToken()->authenticate())
        {
            if($this->validateImageRequest($request->all()))
            {
                $image = $this->saveImage($request, $idHabitant, $idImage);
                if($image){
                    $data = ControllerResponses::okResp(['id'=> $image->id,'path' => asset($image->path)]);
                }
            }
        }
        return response()->json($data, $data->code);
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

    private function validateImageRequest($data)
    {
        $validate = \Validator::make($data,[
            'image' => 'required|file',
            'yRectangle' => 'required',
            'xRectangle' => 'required',
            'hRectangle' => 'required',
            'wRectangle' => 'required',
            'type' => 'required',
        ]);
        return !$validate->fails();
    }
}
