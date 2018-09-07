<?php namespace App\Data\Dao;

use App\Data\Entities\UserEntity;
use Illuminate\Support\Facades\Hash;


class UserDao
{
    public static function save($idPerson, $imei, $device, $password, $fcmToken, $id = null)
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
        $user->fcm_token = $fcmToken;
        $user->password = Hash::make($password);
        $user->fcm_token = $fcmToken;
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

    public static function delete($id)
    {
        $user = UserEntity::find($id)->first();
        if($user != null){
            return $user->delete();
        }
        return false;
    }
}