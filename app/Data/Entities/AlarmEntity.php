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

    protected $appends = ['id','idHogar','idTypeAlarm','idPerson','idTimeStartAlarm','idTimeFinishAlarm','stateMondayAlarm','stateTuesdayAlarm','stateWednesdayAlarm','stateThursdayAlarm','stateFridayAlarm','stateSaturdayAlarm','stateSundayAlarm','stateAlarm' ,'created', 'modified'];

    public function getIdAttribute()
    {
        return $this->attributes['id_alarma'];
    }

    public function getIdHogarAttribute()
    {
        return $this->attributes['id_hogar'];
    }

     public function getIdTypeAlarmAttribute()
    {
        return $this->attributes['id_tipo_alarma'];
    }

    public function getIdPersonAttribute()
    {
        return $this->attributes['id_persona'];
    }

    public function getIdTimeStartAlarmAttribute()
    {
        return $this->attributes['hora_inicio_alarma'];
    }

    public function getIdTimeFinishAlarmAttribute()
    {
        return $this->attributes['hora_termino_alarma'];
    }

    public function getStateMondayAlarmAttribute()
    {
        return $this->attributes['estado_lunes_alarma'];
    }

    public function getStateTuesdayAlarmAttribute()
    {
        return $this->attributes['estado_martes_alarma'];
    }

    public function getStateWednesdayAlarmAttribute()
    {
        return $this->attributes['estado_miercoles_alarma'];
    }

    public function getStateThursdayAlarmAttribute()
    {
        return $this->attributes['estado_jueves_alarma'];
    }

    public function getStateFridayAlarmAttribute()
    {
        return $this->attributes['estado_viernes_alarma'];
    }

    public function getStateSaturdayAlarmAttribute()
    {
        return $this->attributes['estado_sabado_alarma'];
    }

    public function getStateSundayAlarmAttribute()
    {
        return $this->attributes['estado_domingo_alarma'];
    }

    public function getStateAlarmAttribute()
    {
        return $this->attributes['estado_alarma'];
    }

    public function getCreatedAttribute()
    {
        return $this->attributes['fecha_hora_registro_persona'];
    }

    public function getModifiedAttribute()
    {
        return $this->attributes['fecha_hora_modificacion_persona'];
    }

    public function home()
    {
        return $this->hasOne('App\Data\Entities\HomeEntity', 'id_hogar', 'id_hogar');
    }
}
