<?php namespace App\Data\Entities;

use Illuminate\Database\Eloquent\Model;

class DetectionImageEntity extends Model
{
    protected $table = 'deteccion_imagen';
    protected $primaryKey = 'id_deteccion_imagen';

    const CREATED_AT    =   'fecha_hora_registro_deteccion_imagen';
    const UPDATED_AT    =   'fecha_hora_modificacion_deteccion_imagen';

    protected $fillable =[
        'id_deteccion',
        'id_imagen'
    ];

    protected $hidden =[
        'id_deteccion_imagen',
        'id_deteccion',
        'id_imagen',
        'fecha_hora_registro_deteccion_imagen',
        'fecha_hora_modificacion_deteccion_imagen'
    ];

    protected $appends = ['id', 'detectionId', 'imageId'];

    public function getIdAttribute()
    {
        return $this->attributes['id_deteccion_imagen'];
    }

    public function getDetectionIdAttribute()
    {
        return $this->attributes['id_deteccion'];
    }

    public function getImageIdAttribute()
    {
        return $this->attributes['id_imagen'];
    }

    public function image()
    {
        return $this->hasOne('App\Data\Entities\ImageEntity', 'id_imagen', 'id_imagen');
    }
}