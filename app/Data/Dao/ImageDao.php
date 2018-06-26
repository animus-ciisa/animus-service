<?php

namespace App\Data\Dao;
use App\Data\Entities\ImageEntity;


class ImageDao
{
    public function byId($id)
    {
        $image = ImageEntity::where('id_imagen', $id)->get()->first();
        if($image){
            return $image;
        }
        return null;
    }

    public static function save($idPersona,$path,$name,$yRectangle,$xRectangle,$hRectangle,$wRectangle,$type, $id = null)
    {
        $image = null;
		if($id != null){
            $image = ImageEntity::where('id_imagen', $id)->get()->first();
			if(!$image){
				return null;
			}
		}else{
            $image = new ImageEntity();
        }	
        $image->id_persona = $idPersona;
        $image->path_imagen = $path;
        $image->nombre_imagen = $name;
        $image->y_rectangulo_imagen = $yRectangle;
        $image->x_rectangulo_imagen = $xRectangle;
        $image->ancho_rectangulo_imagen = $hRectangle;
        $image->alto_rectangulo_imagen = $wRectangle;
        $image->tipo_imagen = $type;
        
        if($image->save()){
            return $image;
        }
        return null;
    }    

}