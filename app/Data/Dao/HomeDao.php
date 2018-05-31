<?php

namespace App\Data\Dao;

use App\Data\Entities\HomeEntity;
use Illuminate\Support\Facades\Hash;

class HomeDao
{
	
	public static function all()
	{
		$homes = HomeEntity::all();
		if($homes->count() > 0){
			return $homes;
		}
		return [];
	}
	
	public static function byId($id)
	{
		$home = HomeEntity::find($id)->first();
		if($home){
			return $home;
		}
		return null;
	}
	
	public static function save($nick, $email, $password , $avatar, $id = null)
	{
		$home = null;
		if($id != null){
			$home = HomeEntity::find($id)->first();
			if(!$home){
				return null;
			}
		}else{
			$home = new HomeEntity();
		}	
		$home->nick_hogar = $nick;
        $home->email_hogar = $email;
		$home->password = Hash::make($password);
		$home->avatar_hogar = $avatar;
        if($home->save())
        {
			return $home;
		}
		return null;
	}
    
    public static function getByEmail($mail)
    {
        $mailHome = HomeEntity::where('email_hogar', '=',$mail)->first();
		if($mailHome){
			return $mailHome;
		}
		return null;
    }

}