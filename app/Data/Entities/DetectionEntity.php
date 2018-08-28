<?php namespace App\Data\Entities;

use Illuminate\Database\Eloquent\Model;

class DetectionEntity extends Model
{
    protected $table = 'deteccion';
    protected $primaryKey = 'id_deteccion';

    const CREATED_AT    =   'fecha_hora_registro_deteccion';
    const UPDATED_AT    =   'fecha_hora_modificacion_deteccion';

    protected $fillable =[
        'id_alarma',
        'hubo_deteccion'
    ];

    protected $hidden =[
        'id_deteccion',
        'id_alarma',
        'hubo_deteccion',
        'fecha_hora_registro_deteccion',
        'fecha_hora_modificacion_deteccion'
    ];

    protected $appends = ['id', 'has', 'created'];

    public function getIdAttribute()
    {
        return $this->attributes['id_deteccion'];
    }

    public function getHasAttribute()
    {
        return $this->attributes['hubo_deteccion'];
    }

    public function getCreatedAttribute()
    {
        return $this->attributes['fecha_hora_registro_deteccion'];
    }

    public function alarm()
    {
        return $this->hasOne('App\Data\Entities\AlarmEntity', 'id_alarma', 'id_alarma');
    }

    public function images()
    {
        return $this->hasMany('App\Data\Entities\DetectionImageEntity', 'id_deteccion', 'id_deteccion');
    }
}