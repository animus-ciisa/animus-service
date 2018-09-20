<?php

namespace App\Data\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Authenticatable;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use Illuminate\Support\Facades\Auth;
use Hash;

class HomeEntity extends Model implements AuthenticatableContract, CanResetPasswordContract
{
    use Authenticatable, CanResetPassword;
    protected $table = 'hogar';
    protected $primaryKey='id_hogar';

    const CREATED_AT    =   'fecha_hora_registro_hogar';
    const UPDATED_AT    =   'fecha_hora_modificacion_hogar';

    protected $fillable =[
        'nick_hogar',
        'avatar_hogar',
        'email_hogar',
        'password'
    ];

    protected $hidden = [
        'id_hogar',
        'nick_hogar',
        'avatar_hogar',
        'email_hogar',
        'password',
        'fecha_hora_registro_hogar',
        'fecha_hora_modificacion_hogar'
    ];

    protected $appends = ['id', 'nick', 'avatar', 'email', 'created', 'modified'];

    public function getIdAttribute()
    {
        return $this->attributes['id_hogar'];
    }

    public function getNickAttribute()
    {
        return $this->attributes['nick_hogar'];
    }

    public function getAvatarAttribute()
    {
        return $this->attributes['avatar_hogar'];
    }

    public function getEmailAttribute()
    {
        return $this->attributes['email_hogar'];
    }

    public function getCreatedAttribute()
    {
        return $this->attributes['fecha_hora_registro_hogar'];
    }

    public function getModifiedAttribute()
    {
        return $this->attributes['fecha_hora_modificacion_hogar'];
    }

    public function habitants()
    {
        return $this->hasMany('App\Data\Entities\HabitantEntity', 'id_hogar', 'id_hogar');
    }

    public function cameras()
    {
        return $this->hasMany('App\Data\Entities\CameraEntity', 'id_hogar', 'id_hogar');
    }

    public function alarms()
    {
        return $this->hasMany('App\Data\Entities\AlarmEntity', 'id_hogar', 'id_hogar');
    }
}
