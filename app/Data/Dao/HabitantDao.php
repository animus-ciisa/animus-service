<?php

namespace App\Data\Dao;
use App\Data\Entities\HabitantEntity;


class HabitantDao
{
    public function byId($id)
    {
        $habitant = HabitantEntity::find($id)->first();
        if($habitant){
            return $habitant;
        }
        return null;
    }
}