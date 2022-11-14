<?php
include_once "../../../configuracion.php";
$data = data_submitted();
$arregloUsuarios =  array();

$objControl = new abmRol();
$listaRoles = $objControl->buscar($data);
$arregloUsuarios =  array();
foreach ($listaRoles as $elem) {

    $nuevoElem['idrol'] = $elem->getID();
    $nuevoElem['rodescripcion'] = $elem->getRolDescripcion();
    array_push($arregloUsuarios, $nuevoElem);
}

//verEstructura($arregloUsuarios);
echo json_encode($arregloUsuarios);
