<?php 
include_once "../../configuracion.php";
$data = data_submitted();
$abmCompra = new abmCompra();

echo json_encode($abmCompra->agregarProdCarrito($data));

?>