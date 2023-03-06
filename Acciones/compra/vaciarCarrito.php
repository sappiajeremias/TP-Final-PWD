<?php
include_once "../../configuracion.php";
$data = data_submitted();
$respuesta = false;
$objC = new abmCompra();

echo json_encode($objC->vaciarCarrito($data['idcompra']));

?>
