<?php

namespace App\Data\Dao;
use App\Data\Entities\HabitantEntity;


class HabitantDao
{
    public static function byId($id)
    {
        $habitant = HabitantEntity::with('user')->where('id_persona', $id)->first();
        if($habitant){
            return $habitant;
        }
        return null;
    }

    public static function save($homeId, $tipoId , $name, $lastname, $birthday, $id = null)
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
        $habitant->nacimiento_persona = $birthday;
        if($habitant->save()){
            return $habitant;
        }
        return null;
    }    

    public static function delete($id)
    {
        $habitant = null;
        if($id != null)
        {
			$habitant = HabitantEntity::find($id)->first();
			if($habitant != null){
				return $habitant->delete();
            }
        }
        return false;
    }

    public static function byHome($idHogar, $date = null)
    {
        $query = HabitantEntity::with('user')->where('id_hogar', $idHogar);
        if($date != null){
            $query->where('fecha_hora_modificacion_persona', '>=', date('Y-m-d H:i:s', strtotime($date)));
        }
        return $query->get();
    }

    public static function byHomeWithEmotion($idHogar)
    {
        return HabitantEntity::with('emotions')
            ->where('id_hogar', $idHogar)->get();
    }

}