<?php
include_once "../../../configuracion.php";
$data = data_submitted();
$respuesta = false;

$arreglo = ['idrol'=>$data['idrol'],'rodescripcion'=>$data['descripcion']];
if (!empty($data)){
    $objAbmRol = new abmRol();
    $respuesta = $objAbmRol->modificacion($arreglo);
    if (!$respuesta){
        $mensajeError = "No se pudo modificar el Rol";
    }   
}
$retorno['respuesta'] = $respuesta;
if (isset($mensajeError)){
    
    $retorno['mensajeError']=$mensajeError;
    
}
echo json_encode($retorno);
?>