<?php namespace App\Data\Entities;

use Illuminate\Database\Eloquent\Model;

class EmotionEntity extends Model
{
    protected $table = 'emocion';
    protected $primaryKey = 'id_emocion';

    const CREATED_AT    =   'fecha_hora_registro_emocion';
    const UPDATED_AT    =   'fecha_hora_modificacion_emocion';

    protected $fillable = [
        'id_emocion',
        'id_persona',
        'tipo_emocion'
    ];

    protected $hidden = [
        'id_emocion',
        'id_persona',
        'tipo_emocion',
        'fecha_hora_registro_emocion',
        'fecha_hora_modificacion_emocion'
    ];

    protected $appends = ['id', 'habitantId', 'type', 'created'];

    public function getIdAttribute()
    {
        return $this->attributes['id_emocion'];
    }

    public function getHabitantIdAttribute()
    {
        return $this->attributes['id_persona'];
    }

    public function getTypeAttribute()
    {
        return $this->attributes['tipo_emocion'];
    }

    public function getCreatedAttribute()
    {
        return $this->attributes['fecha_hora_registro_emocion'];
    }
}