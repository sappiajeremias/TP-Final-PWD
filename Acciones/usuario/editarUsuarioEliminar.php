<?php
include_once "../../configuracion.php";
$data = data_submitted();
$obj = new abmUsuarioRol();
$arregloRoles = ['idusuario'=>$data['idusuario'], 'idrol'=>$data['idrol']];

echo json_encode($obj->baja($arregloRoles));
?>