<?php
include_once "../../configuracion.php";
$data = data_submitted();
$objC = new abmCompra;

echo json_encode($objC->listarComprasUsuarios());
?>