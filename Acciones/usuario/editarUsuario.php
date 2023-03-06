<?php
include_once "../../configuracion.php";
$data = data_submitted();
$objUsuRol = new abmUsuarioRol();
$arregloUsuRol = ['idusuario'=>$data['idusuario'], 'idrol'=>$data['idrol']];

echo json_encode($objUsuRol->alta($arregloUsuRol));
?>