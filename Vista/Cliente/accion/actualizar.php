<?php
include_once "../../../configuracion.php";
$data = data_submitted();
$respuesta = false;

if (md5($data['uspass1'])===md5($data['uspass2'])){
    $arregloUsu = [
    'idusuario'=>$data['idusuario'],
    'usnombre'=>$data['usnombre'],
    'usmail'=>$data['usmail'],
    'uspass'=>md5($data['uspass1'])];
    $obj = new abmUsuario();
    $respuesta = $obj->modificacion($arregloUsu);
    
    if (!$respuesta){
        $sms_error = " La modificacion no pudo concretarse";
    }else {
        $session = new Session();
        $session->cerrar();
        header('Location: ../../Login/login.php');
    }
    
}
$retorno['respuesta'] = $respuesta;
if (isset($mensaje)){
    
    $retorno['errorMsg']=$sms_error;
    
}
echo json_encode($retorno);
?>