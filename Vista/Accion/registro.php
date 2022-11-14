<?php
include_once "../../configuracion.php";

$datos = data_submitted();

if (!empty($datos)){
    $abmUsuario = new abmUsuario();
    $datos['uspass'] = md5($datos['uspass']);
    if($datos['usnombre'] !== null && $abmUsuario->alta($datos)){
        $objUser = $abmUsuario->buscar(['usnombre'=>$datos['usnombre']]);
        $parametro = ['idusuario'=>$objUser[0]->getID(),'idrol'=>3];

        if($abmUsuario->alta_rol($parametro)){
            $mensaje = "El usuarioRol fue creado con exito";
        } else {
            $mensaje = "Hubo un error al crear el usuarioRol";
        }
    }else {
        $mensaje = "Algo salió mal en el registro";
    }
}

echo "<script> window.location.href='../Home/index.php?mensaje=".urlencode($mensaje)."'</script>";
