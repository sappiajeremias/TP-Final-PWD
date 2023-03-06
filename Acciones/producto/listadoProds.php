<?php 
include_once "../../configuracion.php";
$data = data_submitted();
$objCI = new abmCompraItem();

echo json_encode($objCI->listarProductosPorCompra($data));

