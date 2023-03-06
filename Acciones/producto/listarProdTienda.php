<?php
include_once "../../configuracion.php";
$abmProducto = new abmProducto();

echo json_encode($abmProducto->listarProdTienda());