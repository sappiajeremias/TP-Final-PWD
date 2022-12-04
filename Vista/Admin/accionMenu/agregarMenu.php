<?php
include_once('../../../configuracion.php');

$datos = data_submitted();
$obj_menu_abm = new abmMenu();
$arrayObjMenu = $obj_menu_abm->buscar($datos);
echo json_encode($obj_menu_abm->alta($datos));

