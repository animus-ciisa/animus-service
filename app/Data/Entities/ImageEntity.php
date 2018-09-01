<?php

namespace App\Data\Entities;

use Illuminate\Database\Eloquent\Model;


class ImageEntity extends Model
{
    protected $table = 'imagen';
    protected $primaryKey='id_imagen';

    const CREATED_AT    =   'fecha_hora_registro_imagen';
    const UPDATED_AT    =   'fecha_hora_modificacion_imagen';

    protected $fillable =[
        'id_imagen',
        'nombre_imagen',
        'y_rectangulo_imagen',
        'x_rectangulo_imagen',
        'alto_rectangulo_imagen',
        'ancho_rectangulo_imagen',
        'tipo_imagen',
    ];

    protected $hidden = [        
        'id_imagen',
        'id_persona',
        'path_imagen',
        'nombre_imagen',
        'y_rectangulo_imagen',
        'x_rectangulo_imagen',
        'alto_rectangulo_imagen',
        'ancho_rectangulo_imagen',
        'tipo_imagen',
        'fecha_hora_registro_imagen',
        'fecha_hora_modificacion_imagen'
    ];

    protected $appends = ['id','idPersona','path', 'name', 'yRectangle','xRectangle','hRectangle','wRectangle','type', 'created', 'modified'];

    public function getIdAttribute()
    {
        return $this->attributes['id_imagen'];
    }

    public function getIdPersonaAttribute()
    {
        return $this->attributes['id_persona'];
    }

    public function getPathAttribute()
    {
        return $this->attributes['path_imagen'];
    }

    public function getNameAttribute()
    {
        return $this->attributes['nombre_imagen'];
    }

    public function getyRectangleAttribute()
    {
        return $this->attributes['y_rectangulo_imagen'];
    }

    public function getxRectangleAttribute()
    {
        return $this->attributes['x_rectangulo_imagen'];
    }

    public function gethRectangleAttribute()
    {
        return $this->attributes['alto_rectangulo_imagen'];
    }

    public function getwRectangleAttribute()
    {
        return $this->attributes['ancho_rectangulo_imagen'];
    }

    public function getTypeAttribute()
    {
        return $this->attributes['tipo_imagen'];
    }


    public function getCreatedAttribute()
    {
        return $this->attributes['fecha_hora_registro_imagen'];
    }

    public function getModifiedAttribute()
    {
        return $this->attributes['fecha_hora_modificacion_imagen'];
    }
}