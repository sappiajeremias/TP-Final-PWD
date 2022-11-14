<?php 
include_once "../../../configuracion.php";
$data = data_submitted();
$respuesta = false;
if (!empty($data)){
        $objAbmuRol = new abmRol();
        $respuesta = $objAbmRol->alta($data);
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