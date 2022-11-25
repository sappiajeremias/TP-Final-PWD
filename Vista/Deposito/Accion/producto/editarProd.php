<?php
include_once "../../../../configuracion.php";
$data = data_submitted();
$respuesta = false;
if (isset($data['idproducto'])){
    $obj = new abmProducto();
    $respuesta = $obj->modificacion($data);
    if (!$respuesta){
        $mensajeError = " La modificacion no pudo concretarse";
    }
    
}
$retorno['respuesta'] = $respuesta;
if (isset($mensajeError)){
    
    $retorno['mensajeError']=$mensajeError;
    
}
echo json_encode($retorno);
?>