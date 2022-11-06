<?php
include_once('../Vista/Estructura/cabecera.php');

function login($sesion, $data)
{
    //Verificamos que los datos enviados no esten vacios
    if (isset($data['usnombre']) && isset($data['uspass']) && $sesion->activa()) {
        //Iniciamos la sesion con los datos enviados
        $sesion->iniciar($data['usnombre'], $data['uspass']);
        //Validamos que el usuario este cargado en la BD 
        if ($sesion->validar()) {

            $objU_R = ObtenerDatos();

            //Tomamos la descripcion del Rol para saber cual es y redireccionar a las paginas cU_rrespondientes
            $desc_Rol = $objU_R[0]->getObjRol()->getRoldescripcion();

            // Dependiendo de los permisos lo redireccionamos
            switch ($desc_Rol) {
                case 'admin':
                    header("Location:../Vista/paginaSegura.php");
                    break;
                case 'user':
                    header("Location:./listarUsuario.php?idusuario={$objU_R[0]->getObjUsuario()->getIdusuario()}&roldescripcion={$objU_R[0]->getObjRol()->getRoldescripcion()}");
                    break;

                default:

                    header("Location:./PaginaCliente.php");

                    break;
            }
        } else {
            header("Location:./Index_login.php?accion=invalido");
        }
    } else {
        header("Location:./Index_login.php?accion=vacio");
    }
}

function ObtenerDatos()
{

    //instaciamos el control del usuario
    $objU = new abmUsuario();
    //Buscamos los datos del Usuario
    $user = $objU->buscar($_SESSION);
    //Buscamos los datos del Rol por medio de la clase UsurioRol el cual nos devuelve el objeto Usuario y su correspondiente objeto Rol
    if ($user != null) {
        $array_UserRol = $objU->DarRol(['idusuario' => $user[0]->getIdusuario()]);
    };

    return $array_UserRol;
}
