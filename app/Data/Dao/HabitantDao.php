<?php

namespace App\Data\Dao;
use App\Data\Entities\HabitantEntity;


class HabitantDao
{
    public static function byId($id)
    {
        $habitant = HabitantEntity::where('id_habintante', $id)->first();
        if($habitant){
            return $habitant;
        }
        return null;
    }

    public static function save($homeId,$tipoId, $name, $lastname, $brithday, $id = null)
    {
        $habitant = null;
		if($id != null){
			$habitant = HabitantEntity::find($id)->first();
			if(!$habitant){
				return null;
			}
		}else{
            $habitant = new HabitantEntity();
        }	
        $habitant->id_hogar = $homeId;
        $habitant->id_tipo_persona = $tipoId;
        $habitant->nombre_persona = $name;
        $habitant->apellido_persona = $lastname;
        $habitant->nacimiento_persona = $brithday;
        if($habitant->save()){
            return $habitant;
        }
        return null;
    }

}