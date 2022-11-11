<?php

include_once '../configuracion.php';

$data = data_submitted();

$idNuevoRol = $data['nuevorol'];

$sesion = new Session();

$idRolBuscar = $sesion->buscarIdRol($idNuevoRol); // VERIFICAMOS SI EL ID ENVIADO COINCIDE CON ALGÚN ROL EXISTENTE


if($idRolBuscar<>null){ // SI EXISTE EL ROL
    if($_SESSION['rolactivoid']<>$idRolBuscar){ // SI EL ROL ES DISTINTO AL YA SETEADO HACEMOS EL CAMBIO
        $_SESSION['rolactivoid'] = $idRolBuscar; // SETEAMOS EL NUEVO ID ROL
        switch($idRolBuscar){ // SETEAMOS LA DESCRIPCION DEL NUEVO ROL
            case '1':
                $_SESSION['rolactivodescripcion'] = 'admin';
                break;
            case '2':
                $_SESSION['rolactivodescripcion'] = 'deposito';
                break;
            case '3':
                $_SESSION['rolactivodescripcion'] = 'cliente';
                break;
        }
        $mensaje = "Se cambió exitosamente al rol: ".strtoupper($_SESSION['rolactivodescripcion']);
    } else {
        $mensaje = "Usted ya tiene activo el rol: ".strtoupper($_SESSION['rolactivodescripcion']);
    }
} else {
    $mensaje = "No se pudo actualizar el rol!";
}

header('Location: ../Vista/Home/index.php?mensaje='.urlencode($mensaje));