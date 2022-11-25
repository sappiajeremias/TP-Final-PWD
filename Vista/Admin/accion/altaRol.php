<?php 
include_once "../../../configuracion.php";
$data = data_submitted();
$respuesta = false;
$arreglo = ['rodescripcion'=>$data['rodescripcion']];
if (!empty($data)){

        $objAbmRol = new abmRol();
        $respuesta = $objAbmRol->altaSinId($arreglo);
        if (!$respuesta){
            $mensajeError = " No se pudo dar de alta al Rol";
        }
}
$retorno['respuesta'] = $respuesta;
if (isset($mensajeError)){
    $retorno['mensajeError']=$mensajeError;
}
 echo json_encode($retorno);
?>