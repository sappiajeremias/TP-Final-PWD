<?php
include_once "../../configuracion.php";
$objC= new abmCompra();
$objUsuario= new abmUsuario();
$session = new Session();
$idUser=$session->getIDUsuarioLogueado();

echo json_encode($objC->listadoProdCarrito($objUsuario->obtenerCarrito($idUser)));
