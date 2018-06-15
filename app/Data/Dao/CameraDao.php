<?php

namespace App\Data\Dao;

use App\Data\Entities\CameraEntity;

class CameraDao
{

    public static function getByHome($homeId)
    {
        $cameras = CameraEntity::where('id_hogar', $homeId)->get();
        return $cameras;
    }

    public static function save($homeId, $name, $status, $associate, $id = null)
    {
        $camera = null;
		if($id != null){
			$camera = CameraEntity::find($id)->first();
			if(!$camera){
				return null;
			}
		}else{
            $camera = CameraEntity::where('id_hogar', $homeId)->where('nombre_camara', $name)->first();
			if(!$camera){
				$camera = new CameraEntity();
			}
        }	
        $camera->id_hogar = $homeId;
        $camera->nombre_camara = $name;
        $camera->estado_camara = $status;
        $camera->asociada_camara = $associate;
        if($camera->save()){
            return $camera;
        }
        return null;
    }

    public static function delete($idCamera)
    {
        $camera = CameraEntity::where('id_camara', $idCamera)->first();
        if($camera){
            $camera->delete();
        }
        return true;
    }

}