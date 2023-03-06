<?php
include_once "../../configuracion.php";
$data = data_submitted();
$objMenu_abm = new abmMenu();
echo json_encode($objMenu_abm->baja($data));
?>