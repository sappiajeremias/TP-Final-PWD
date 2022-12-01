<?php

include_once('../../../configuracion.php');

$data = data_submitted();



    $objAbmMenu = new abmMenu();
    $objMenuRol= new abmMenuRol();

    $respuesta=$objMenuRol->modificacion(['idrol'=>$data['idrol'], 'idmenu'=>$data['idmenu']]);
    if($respuesta){

  

    /* $objMenu = $objAbmMenu->buscar(['idmenu'=>$data['idmenu']]); */

    $arraOBJ =[
        'idmenu'=>$data['idmenu'],
        'menombre'=>$data['menombre'],
        'medescripcion'=>$data['medescripcion'],
        'medeshabilitado'=>$data['medeshabilitado'],
        'idpadre'=>$data['idpadre']
    ];

    $respuesta = $objAbmMenu->modificacion($arraOBJ);
    if (!$respuesta) {
        $sms_error = " La modificacion no pudo concretarse";
    }
}else{
    $sms_error = "La relacion con rol no pudo concretarse.";
}

   


$retorno['respuesta'] = $respuesta;
if (isset($sms_error)) {

    $retorno['errorMsg'] = $sms_error;
}

 echo json_encode($retorno);
