<?php
class controlImagenes
{
    public function cargarImagen($nombreTabla, $imagen, $nombreCarpeta)
    {
        $id = time().uniqid(rand());
        $nombreArchivoImagen = $nombreTabla . $id . ".png";

        $respuesta = false;
        if(imagepng(imagecreatefromstring(file_get_contents($imagen['tmp_name'])), $GLOBALS['IMGS'] . $nombreCarpeta . $nombreArchivoImagen)){
            $respuesta = true;
        }

        return ['respuesta'=> $respuesta, 'nombre'=>$nombreArchivoImagen];
    }

    public function eliminarImagen($nombreArchivoImagen, $nombreCarpeta)
    {
        $dir = $GLOBALS['IMGS'] . $nombreCarpeta . $nombreArchivoImagen;

        if (!is_null($dir)) {
            unlink($dir);
        }
    }
}
