<?php

namespace App\Data\Dao;
use App\Data\Entities\AlarmEntity;


class AlarmDao
{
    public static function byId($id)
    {
        $alarm = AlarmEntity::where('id_alarma', $id)->first();
        if($habitant){
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

}