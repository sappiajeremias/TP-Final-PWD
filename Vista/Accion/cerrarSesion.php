<?php
include_once '../Estructura/cabecera.php';
$sesion->cerrar();
$mensaje = "Sesión cerrada exitosamente!";
echo "<script> window.location.href='../Home/index.php?mensaje=".urlencode($mensaje)."'</script>";
?>