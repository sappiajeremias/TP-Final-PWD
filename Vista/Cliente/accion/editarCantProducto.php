<?php
include_once "../../../configuracion.php";
$data = data_submitted();
$respuesta=false;
$obj = new abmCompraItem();
$respuesta = $obj->modificacion($data);
if (!$respuesta){
        $mensajeError = "No se pudo eliminar al producto";
}


$retorno['respuesta'] = $respuesta;
if (isset($mensajeError)){
   
    $retorno['mensajeError']=$mensajeError;

}
    echo json_encode($retorno);
?>