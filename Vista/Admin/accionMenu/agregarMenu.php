<?php
include_once('../../../configuracion.php');

$datos = data_submitted();
$respuesta['respuesta'] = false;

if (isset($datos['menombre']) && isset($datos['medescripcion'])) {
  $obj_menu_abm = new abmMenu();
  $array_obj_ABMmenu = $obj_menu_abm->buscar($datos);
  $objPadre= $obj_menu_abm->buscar(['idpadre'=>$datos['idpadre']]);

  if (empty($array_obj_ABMmenu) && !empty($objPadre)) {
    if ($obj_menu_abm->alta($datos)) {
      $respuesta['respuesta'] = true;
    }
  }
}
echo json_encode($respuesta);
