<?php 
include_once "../../../configuracion.php";
$data = data_submitted();

$respuesta = false;
if (isset($data['usnombre'])){
        $obj = new abmUsuario();
        

        $data['uspass']= md5($data['uspass']);
        $respuesta = $obj->altaSinID($data);
        
        if (!$respuesta){
            $sms_error = " La accion de crear no pudo concretarse";
        } else {
            $objUsu = new abmUsuario();
            $arregloUsu = $objUsu->buscar(['usnombre'=>$data['usnombre'], 'usmail' => $data['usmail']]);
            $objUsuRol = new abmUsuarioRol();
            $objUsuRol->alta(['idrol'=>$data['idrol'],'idusuario'=>$arregloUsu[0]->getID()]);
        }
}
$retorno['respuesta'] = $respuesta;
if (isset($mensaje)){
    
    $retorno['errorMsg']=$sms_error;
   
}
 echo json_encode($retorno);


