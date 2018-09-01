<?php

namespace App\Data\Dao;
use App\Data\Entities\AlarmEntity;
use App\Data\Entities\DetectionEntity;
use App\Data\Entities\DetectionImageEntity;


class AlarmDao
{
    public static function byId($id)
    {
        $alarm = AlarmEntity::with('habitant')->where('id_alarma', $id)->first();
        if($alarm){
            return $alarm;
        }
        return null;
    }

    public static function save($homeId,$idTypeAlarm,$idPerson,$idTimeStartAlarm,$idTimeFinishAlarm,$stateMondayAlarm,$stateTuesdayAlarm,$stateWednesdayAlarm,$stateThursdayAlarm,$stateFridayAlarm,$stateSaturdayAlarm,$stateSundayAlarm,$stateAlarm, $id = null)
    {
        $alarm = null;
		if($id != null){
			$alarm = AlarmEntity::find($id)->first();
			if(!$alarm){
				return null;
			}
		}else{
            $alarm = new AlarmEntity();
        }	
        $alarm->id_hogar = $homeId;
        $alarm->id_tipo_alarma = $idTypeAlarm;
        $alarm->id_persona = $idPerson;
        $alarm->hora_inicio_alarma = $idTimeStartAlarm;
        $alarm->hora_termino_alarma = $idTimeFinishAlarm;
        $alarm->estado_lunes_alarma = $stateMondayAlarm;
        $alarm->estado_martes_alarma = $stateTuesdayAlarm;
        $alarm->estado_miercoles_alarma = $stateWednesdayAlarm;
        $alarm->estado_jueves_alarma = $stateThursdayAlarm;
        $alarm->estado_viernes_alarma = $stateFridayAlarm;
        $alarm->estado_sabado_alarma = $stateSaturdayAlarm;
        $alarm->estado_domingo_alarma = $stateSundayAlarm;
        $alarm->estado_alarma = $stateAlarm;
        if($alarm->save()){
            return $alarm;
        }
        return null;
    }    

    public static function delete($id)
    {
        $alarm = null;
        if($id != null)
        {
			$alarm = AlarmEntity::find($id)->first();
			if($alarm != null){
				$alarm->delete();
            }else
            {
                return null;
            }
        }
    }

    public static function saveDetection($alarm, $hasDetection, $id = null)
    {
        $detection = null;
        if($id != null){
            $detection = DetectionEntity::find($id)->get()->first();
            if(!$detection){
                return null;
            }
        }else{
            $detection = new DetectionEntity();
        }
        $detection->id_alarma = $alarm;
        $detection->hubo_deteccion = $hasDetection;
        if($detection->save()){
            return $detection;
        }
        return null;
    }

    public static function saveDetectionImage($detection, $image, $id = null)
    {
        $detectionImage = null;
        if($id != null){
            $detectionImage = DetectionImageEntity::find($id)->get()->first();
            if(!$detectionImage){
                return null;
            }
        }else{
            $detectionImage = new DetectionImageEntity();
        }
        $detectionImage->id_deteccion = $detection;
        $detectionImage->id_imagen = $image;
        if($detectionImage->save()){
            return $detectionImage;
        }
        return null;
    }

    public static function getFullDetection($detectionId)
    {
        $data = DetectionEntity::with('images.image')
            ->with('alarm.home.habitants.user')
            ->where('id_deteccion', $detectionId)->get()->first();
        return $data;
    }
}