<?php
include_once "../../configuracion.php";
$data = data_submitted();
$arreglo = ['idrol'=>$data['idrol'],'rodescripcion'=>$data['descripcion']];
$objAbmRol = new abmRol();

echo json_encode($objAbmRol->modificacion($arreglo));
?>