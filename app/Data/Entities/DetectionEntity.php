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
        'id_tipo_deteccion',
        'imagen_deteccion'
    ];

    protected $hidden =[
        'id_deteccion',
        'id_alarma',
        'id_tipo_deteccion',
        'imagen_deteccion',
        'fecha_hora_registro_deteccion',
        'fecha_hora_modificacion_deteccion'
    ];

    protected $appends = ['id', 'type', 'image', 'created'];

    public function getIdAttribute()
    {
        return $this->attributes['id_deteccion'];
    }

    public function getTypeAttribute()
    {
        return $this->attributes['id_tipo_deteccion'];
    }

    public function getImageAttribute()
    {
        return $this->attributes['imagen_deteccion'];
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