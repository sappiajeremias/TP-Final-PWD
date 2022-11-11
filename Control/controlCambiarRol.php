<?php

include_once '../configuracion.php';

$data = data_submitted();

$idNuevoRol = $data['nuevorol'];

$sesion = new Session();

$idRolBuscar = $sesion->buscarIdRol($idNuevoRol); // VERIFICAMOS SI EL ID ENVIADO COINCIDE CON ALGÚN ROL EXISTENTE

if($idRolBuscar<>null){ // SI EXISTE EL ROL
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
    $mensaje = "Se cambió de rol exitosamente!";
} else {
    $mensaje = "No se pudo actualizar el rol!";
}

header('Location: ../Vista/Home/index.php?mensaje='.urlencode($mensaje));