<?php

namespace App\Data\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Authenticatable;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use Illuminate\Support\Facades\Auth;

class AlarmEntity extends Model
{
    protected $table = 'alarma';
    protected $primaryKey='id_alarma';

    const CREATED_AT    =   'fecha_hora_registro_alarma';
    const UPDATED_AT    =   'fecha_hora_modificacion_alarma';

    protected $fillable =[
        'id_hogar',
        'id_tipo_alarma',
        'id_persona',
        'hora_inicio_alarma',
        'hora_termino_alarma',
        'estado_lunes_alarma',
        'estado_martes_alarma',
        'estado_miercoles_alarma',
        'estado_jueves_alarma',
        'estado_viernes_alarma',
        'estado_sabado_alarma',
        'estado_domingo_alarma',
        'estado_alarma',
    ];

    protected $hidden = [        
        'id_alarma',
        'id_hogar',
        'id_tipo_alarma',
        'id_persona',
        'hora_inicio_alarma',
        'hora_termino_alarma',
        'estado_lunes_alarma',
        'estado_martes_alarma',
        'estado_miercoles_alarma',
        'estado_jueves_alarma',
        'estado_viernes_alarma',
        'estado_sabado_alarma',
        'estado_domingo_alarma',
        'estado_alarma',
        'fecha_hora_registro_alarma',
        'fecha_hora_modificacion_alarma'
    ];

    protected $appends = ['id','idHome','idType','idPerson','startHour','endHour','monday','tuesday','wednesday','thursday','friday','saturday','sunday','status' ,'created', 'modified'];

    public function getIdAttribute()
    {
        return $this->attributes['id_alarma'];
    }

    public function getIdHomeAttribute()
    {
        return $this->attributes['id_hogar'];
    }

     public function getIdTypeAttribute()
    {
        return $this->attributes['id_tipo_alarma'];
    }

    public function getIdPersonAttribute()
    {
        return $this->attributes['id_persona'];
    }

    public function getStartHourAttribute()
    {
        return $this->attributes['hora_inicio_alarma'];
    }

    public function getEndHourAttribute()
    {
        return $this->attributes['hora_termino_alarma'];
    }

    public function getMondayAttribute()
    {
        return $this->attributes['estado_lunes_alarma'];
    }

    public function getTuesdayAttribute()
    {
        return $this->attributes['estado_martes_alarma'];
    }

    public function getWednesdayAttribute()
    {
        return $this->attributes['estado_miercoles_alarma'];
    }

    public function getThursdayAttribute()
    {
        return $this->attributes['estado_jueves_alarma'];
    }

    public function getFridayAttribute()
    {
        return $this->attributes['estado_viernes_alarma'];
    }

    public function getSaturdayAttribute()
    {
        return $this->attributes['estado_sabado_alarma'];
    }

    public function getSundayAttribute()
    {
        return $this->attributes['estado_domingo_alarma'];
    }

    public function getStatusAttribute()
    {
        return $this->attributes['estado_alarma'];
    }

    public function getCreatedAttribute()
    {
        return $this->attributes['fecha_hora_registro_alarma'];
    }

    public function getModifiedAttribute()
    {
        return $this->attributes['fecha_hora_registro_alarma'];
    }

    public function home()
    {
        return $this->hasOne('App\Data\Entities\HomeEntity', 'id_hogar', 'id_hogar');
    }

    public function habitant()
    {
        return $this->hasOne('App\Data\Entities\HabitantEntity', 'id_persona', 'id_persona');
    }
}
