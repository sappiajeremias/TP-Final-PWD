<?php
include_once "../../../configuracion.php";
$data = data_submitted();
$respuesta = false;
$arregloRoles = ['idusuario'=>$data['idusuario'], 'idrol'=>$data['idrol']];
if (isset($arregloRoles['idusuario'])){
    $obj = new abmUsuarioRol();
    //$obj->buscar($arregloRoles);
    $respuesta = $obj->baja($arregloRoles);
    
    if (!$respuesta){
        $sms_error = " La modificacion no pudo concretarse";
    }
    
}
$retorno['respuesta'] = $respuesta;
if (isset($mensaje)){
    
    $retorno['errorMsg']=$sms_error;
    
}
echo json_encode($retorno);
?>