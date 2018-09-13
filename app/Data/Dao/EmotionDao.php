<?php

namespace App\Data\Dao;
use App\Data\Entities\EmotionEntity;
use App\Data\Entities\DetectionEntity;

class EmotionDao
{

    public static function save($habitantId, $type)
    {
        $emotion = new EmotionEntity();
        $emotion->id_persona = $habitantId;
        $emotion->tipo_emocion = $type;

        if($emotion->save()){
            return $emotion;
        }
        return null;
    }

}