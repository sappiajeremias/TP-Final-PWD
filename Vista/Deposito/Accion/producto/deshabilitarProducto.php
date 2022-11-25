<?php
include_once "../../../../configuracion.php";
$data = data_submitted();
$respuesta=false;
if (!empty($data)){
    $obj = new abmProducto();

    $fecha = date('Y-m-d H:i:s');

    $data['prodeshabilitado'] = $fecha;

    $respuesta = $obj->modificacion($data);

    if (!$respuesta){
        $mensajeError = "No se pudo deshabilitar al producto";
    }
}

$retorno['respuesta'] = $respuesta;
if (isset($mensajeError)){
   
    $retorno['mensajeError']=$mensajeError;

}
echo json_encode($retorno);
?>