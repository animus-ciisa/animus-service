<?php

namespace App\Data\Dao;
use App\Data\Entities\EmotionEntity;
use App\Data\Entities\DetectionEntity;

class EmotionDao
{

    public static function save($habitantId, $homeId, $type)
    {
        $emotion = new EmotionEntity();
        $emotion->id_persona = $habitantId;
        $emotion->id_hogar = $homeId;
        $emotion->tipo_emocion = $type;

        if($emotion->save()){
            return $emotion;
        }
        return null;
    }

    public static function byHome($homeId, $date = null)
    {
        $query = EmotionEntity::leftJoin('persona', function ($join){
            $join->on('emocion.id_persona', '=', 'persona.id_persona');
        })->where('persona.id_hogar', $homeId);
        if($date != null){
            $query->where('fecha_hora_modificacion_emocion', '>=', date('Y-m-d H:i:s', strtotime($date)));
        }
        return $query->get();
    }
}