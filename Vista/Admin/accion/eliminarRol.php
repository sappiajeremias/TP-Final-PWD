<?php
include_once "../../../configuracion.php";
$data = data_submitted();
$respuesta=false;
$arreglo = ['idrol'=>$data['idrol']];
if (!empty($data)){
    $objAbmRol = new abmRol();
    $respuesta = $objAbmRol->baja($arreglo);
    if (!$respuesta){
        $mensajeError = "No se pudo eliminar al Rol";
    }
}

$retorno['respuesta'] = $respuesta;
if (isset($mensajeError)){
   
    $retorno['mensajeError']=$mensajeError;

}
    echo json_encode($retorno);
?>