<?php
include_once "../../../configuracion.php";
$data = data_submitted();
$respuesta=false;
if (!empty($data)){
    $objAbmUsuario = new abmUsuario();
    $respuesta = $objAbmUsuario->baja($data);
    if (!$respuesta){
        $mensajeError = "No se pudo eliminar al Usuario";
    }
}

$retorno['respuesta'] = $respuesta;
if (isset($mensajeError)){
   
    $retorno['mensajeError']=$mensajeError;

}
    echo json_encode($retorno);
?>