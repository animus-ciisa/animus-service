<?php namespace App\Data\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Authenticatable;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use Illuminate\Support\Facades\Auth;
use Hash;

class UserEntity extends Model implements AuthenticatableContract, CanResetPasswordContract
{
    use Authenticatable, CanResetPassword;

    protected $table = 'usuario';
    protected $primaryKey='id_usuario';

    const CREATED_AT    =   'fecha_hora_registro_usuario';
    const UPDATED_AT    =   'fecha_hora_modificacion_usuario';

    protected $fillable =[
        'id_persona',
        'id_tipo_usuario',
        'imei_usuario',
        'dispositivo_usuario',
        'password'
    ];

    protected $hidden = [
        'id_usuario',
        'id_persona',
        'id_tipo_usuario',
        'imei_usuario',
        'dispositivo_usuario',
        'fecha_hora_registro_usuario',
        'fecha_hora_modificacion_usuario',
        'password'
    ];

    protected $appends = ['id', 'idHabitant', 'imei', 'device', 'created', 'modified'];

    public function getIdAttribute()
    {
        return $this->attributes['id_usuario'];
    }

    public function getIdHabitantAttribute()
    {
        return $this->attributes['id_persona'];
    }

    public function getImeiAttribute()
    {
        return $this->attributes['imei_usuario'];
    }

    public function getDeviceAttribute()
    {
        return $this->attributes['dispositivo_usuario'];
    }

    public function getCreatedAttribute()
    {
        return $this->attributes['fecha_hora_registro_usuario'];
    }

    public function getModifiedAttribute()
    {
        return $this->attributes['fecha_hora_modificacion_usuario'];
    }
}