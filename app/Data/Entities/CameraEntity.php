<?php
namespace App\Data\Entities;

use Illuminate\Database\Eloquent\Model;

class CameraEntity extends Model{

    protected $table = 'camara';
    protected $primaryKey='id_camara';

    const CREATED_AT    =   'fecha_hora_registro_camara';
    const UPDATED_AT    =   'fecha_hora_modificacion_camara';

    protected $fillable =[
        'id_hogar',
        'nombre_camara',
        'estado_camara',
        'asociada_camara'
    ];

    protected $hidden =[
        'id_hogar',
        'id_camara',
        'nombre_camara',
        'estado_camara',
        'asociada_camara',
        'fecha_hora_registro_camara',
        'fecha_hora_modificacion_camara'
    ];

    protected $appends = ['id', 'homeId', 'name', 'status', 'associate', 'created', 'updated'];

    public function getIdAttribute()
    {
        return $this->attributes['id_camara'];
    }

    public function getHomeIdAttribute()
    {
        return $this->attributes['id_hogar'];
    }

    public function getNameAttribute()
    {
        return $this->attributes['nombre_camara'];
    }

    public function getStatusAttribute()
    {
        return $this->attributes['estado_camara'];
    }

    public function getAssociateAttribute()
    {
        return $this->attributes['asociada_camara'];
    }

    public function getCreatedAttribute()
    {
        return $this->attributes['fecha_hora_registro_camara'];
    }

    public function getUpdatedAttribute()
    {
        return $this->attributes['fecha_hora_modificacion_camara'];
    }
}