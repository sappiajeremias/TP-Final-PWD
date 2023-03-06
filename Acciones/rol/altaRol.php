<?php 
include_once "../../configuracion.php";
$data = data_submitted();
$objAbmRol = new abmRol();
$arreglo = ['rodescripcion'=>$data['rodescripcion']];

 echo json_encode($objAbmRol->altaSinId($arreglo));
?>