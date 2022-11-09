<?php
include_once '../Estructura/cabecera.php';
$sesion = new Session();
$sesion->cerrar();
header("Location:../Home/index.php");
?>