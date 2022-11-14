<?php
include_once "../../../configuracion.php";
$data = data_submitted();
$respuesta = false;
if (!empty($data)){
    $objAbmUsuario = new abmUsuario();
    $respuesta = $objAbmUsuario->modificacion($data);
    if (!$respuesta){
        $mensajeError = "No se pudo modificar al Usuario";
    }   
}
$retorno['respuesta'] = $respuesta;
if (isset($mensajeError)){
    
    $retorno['mensajeError']=$mensajeError;
    
}
echo json_encode($retorno);
?>