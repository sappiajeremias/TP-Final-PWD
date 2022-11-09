<?php
include_once '../Estructura/cabecera.php';
$sesion->cerrar();
$mensaje = "Sesión cerrada exitosamente!";
header('Location:../Home/index.php?mensaje='.urlencode($mensaje));
?>