<?php
include_once "../../configuracion.php";

$abmCompra= new abmCompra();
$session = new Session();
$idUsuario=$session->getIDUsuarioLogueado();
echo json_encode($abmCompra->listarCompras($idUsuario));
?>
