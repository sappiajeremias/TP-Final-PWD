<?php

include_once '../configuracion.php';

$data = data_submitted();

$idNuevoRol = $data['nuevorol'];

$sesion = new Session();
$rolActivo = $sesion->getRolActivo();
$idRolBuscar = $sesion->buscarIdRol($idNuevoRol); // VERIFICAMOS SI EL ID ENVIADO COINCIDE CON ALGÚN ROL EXISTENTE

if($idRolBuscar<>null){ // SI EXISTE EL ROL
    if($rolActivo['id']<>$idRolBuscar){ // SI EL ROL ES DISTINTO AL YA SETEADO HACEMOS EL CAMBIO
        $sesion->setIdRolActivo($idRolBuscar); // SETEAMOS EL NUEVO ID ROL
        switch($idRolBuscar){ // SETEAMOS LA DESCRIPCION DEL NUEVO ROL
            case '1':
                $sesion->setDescripcionRolActivo('admin');
                $rolMensaje = "ADMIN";
                break;
            case '2':
                $sesion->setDescripcionRolActivo('deposito');
                $rolMensaje = "DEPOSITO";
                break;
            case '3':
                $sesion->setDescripcionRolActivo('cliente');
                $rolMensaje = "CLIENTE";
                break;
        }
        $mensaje = "Se cambió exitosamente al rol: ".$rolMensaje;
    } else {
        $mensaje = "Usted ya tiene activo el rol: ".strtoupper($rolActivo['rol']);
    }
} else {
    $mensaje = "No se pudo actualizar el rol!";
}

header('Location: ../Vista/Home/index.php?mensaje='.urlencode($mensaje));