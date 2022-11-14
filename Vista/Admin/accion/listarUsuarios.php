<?php
include_once "../../../configuracion.php";
$data = data_submitted();
$arregloUsuarios =  array();

$objControl = new abmUsuario();
$listaUsuarios = $objControl->buscar($data);
$arregloUsuarios =  array();
foreach ($listaUsuarios as $elem) {

    $nuevoElem['idusuario'] = $elem->getID();
    $nuevoElem['usnombre'] = $elem->getUsNombre();
    $nuevoElem['usmail'] = $elem->getUsMail();
    $nuevoElem['usdeshabilitado'] = $elem->getUsDeshabilitado();
    array_push($arregloUsuarios, $nuevoElem);
}

//verEstructura($arregloUsuarios);
echo json_encode($arregloUsuarios);
