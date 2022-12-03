<?php
include_once('../../../configuracion.php');

$datos = data_submitted();
$obj_menu_abm = new abmMenu();
/* $arreglo['respuesta'] = false; */
$arrayObjMenu = $obj_menu_abm->buscar($datos);
if(empty($arrayObjMenu)){
  if($obj_menu_abm->alta($datos)){
    $arreglo['respuesta'] = true;
  }else{
    $arreglo['mensajeError']="No se pudo dar de alta :(";
  }
}else{
  $arreglo['mensajeError']="Ese menu ya existe.";
}

echo json_encode($arreglo);

