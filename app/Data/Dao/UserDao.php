<?php namespace App\Data\Dao;

use App\Data\Entities\UserEntity;
use Illuminate\Support\Facades\Hash;


class UserDao
{
    public static function save($idPerson, $imei, $device, $password, $id = null)
    {
        $user = null;
        if($id != null){
            $user = UserEntity::find($id)->first();
            if(!$user){
                return null;
            }
        }else{
            $user = new UserEntity();
        }
        $user->id_persona = $idPerson;
        $user->imei_usuario = $imei;
        $user->dispositivo_usuario = $device;
        $user->password = Hash::make($password);
        if($user->save()){
            return $user;
        }
        return null;
    }

    public static function getByImei($imei)
    {
        $user = UserEntity::where('imei_usuario', $imei)->get()->first();
        if(!$user){
            return null;
        }
        return $user;
    }
}