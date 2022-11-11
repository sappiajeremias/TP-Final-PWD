<?php

include_once '../Estructura/cabecera.php';

$data = data_submitted();

$idNuevoRol = $data['idnuevorol'];

$respuesta = $sesion->cambiarRol($idNuevoRol);

if($respuesta){
    $mensaje = "Se cambió de rol exitosamente!";
}  else {
    $mensaje = "No se pudo actualizar el rol!";
}

echo "<script> window.location.href='../Home/index.php?mensaje=".urlencode($mensaje)."'</script>";