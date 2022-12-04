<?php

include_once('../../../configuracion.php');

$data = data_submitted();
$respuesta=false;
$objMenu = new abmMenu();
echo json_encode($objMenu->modificacion($data));


