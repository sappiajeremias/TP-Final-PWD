<?php
include_once '../../configuracion.php';
$sesion = new Session();
$sesion->cerrar();
$mensaje = "Sesión cerrada exitosamente!";
echo "<script> window.location.href='../Home/index.php?mensaje=".urlencode($mensaje)."'</script>";
?>