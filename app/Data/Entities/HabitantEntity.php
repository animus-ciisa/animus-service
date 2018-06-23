<?php

namespace App\Data\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Authenticatable;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use Illuminate\Support\Facades\Auth;
use Hash;

class HabitantEntity extends Model
{
    protected $table = 'persona';
    protected $primaryKey='id_persona';

    const CREATED_AT    =   'fecha_hora_registro_persona';
    const UPDATED_AT    =   'fecha_hora_modificacion_persona';

    protected $fillable =[
        'id_hogar',
        'id_tipo_persona',
        'nombre_persona',
        'apellido_persona',
        'nacimiento_persona',        
    ];

    protected $hidden = [        
        'id_persona',
        'id_hogar',
        'id_tipo_persona',
        'nombre_persona',
        'apellido_persona',
        'nacimiento_persona',
        'fecha_hora_registro_persona',
        'fecha_hora_modificacion_persona'
    ];

    protected $appends = ['id','idHogar','idTipo', 'nombre', 'apellido','nacimiento', 'created', 'modified'];

    public function getIdAttribute()
    {
        return $this->attributes['id_persona'];
    }

    public function getIdHogarAttribute()
    {
        return $this->attributes['id_hogar'];
    }

    public function getIdTipoAttribute()
    {
        return $this->attributes['id_tipo_persona'];
    }

    public function getNombreAttribute()
    {
        return $this->attributes['nombre_persona'];
    }

    public function getApellidoAttribute()
    {
        return $this->attributes['apellido_persona'];
    }

    public function getNacimientoAttribute()
    {
        return $this->attributes['nacimiento_persona'];
    }

    public function getCreatedAttribute()
    {
        return $this->attributes['fecha_hora_registro_persona'];
    }

    public function getModifiedAttribute()
    {
        return $this->attributes['fecha_hora_modificacion_persona'];
    }
}
