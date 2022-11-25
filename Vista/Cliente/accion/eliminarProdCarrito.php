<?php
include_once "../../../configuracion.php";
$data = data_submitted();
$respuesta=false;
if (!empty($data)){
    $obj = new abmCompraItem();
    $respuesta = $obj->baja($data);
    if (!$respuesta){
        $mensajeError = "No se pudo eliminar al producto";
    }
}

$retorno['respuesta'] = $respuesta;
if (isset($mensajeError)){
   
    $retorno['mensajeError']=$mensajeError;

}
    echo json_encode($retorno);
?>