<?php 
include_once "../../../configuracion.php";
$data = data_submitted();
$respuesta = false;
if (!empty($data)){
        $objAbmuUser = new abmUsuario();
        $respuesta = $objAbmUser->alta($data);
        if (!$respuesta){
            $mensajeError = " No se pudo dar de alta al Usuario";
            
        }
}
$retorno['respuesta'] = $respuesta;
if (isset($mensajeError)){

    $retorno['mensajeError']=$mensajeError;
    
}
 echo json_encode($retorno);
?>