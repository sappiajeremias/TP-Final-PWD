<?php
include_once "../../configuracion.php";
$data = data_submitted();
$objAbmRol = new abmRol();

echo json_encode($objAbmRol->baja($data));
?>