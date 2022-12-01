<?php
include_once '../../../configuracion.php';
$sesion = new Session();

if ($sesion->sesionActiva()) {
    $roles = $sesion->getRoles(); // TODOS LOS OBJ ROLES DEL USUARIO ACTIVO
    if (count($roles) > 0) { // SI TIENE AL MENOS UN ROL
        $rolActivo = $sesion->getRolActivo(); // ARREGLO CON ID Y DESCRIPCION DEL ROL ACTIVO
        $abmMenuRol = new abmMenuRol();
        $menuRoles = $abmMenuRol->buscar(['idrol' => $rolActivo['id']]); // BUSCAMOS LOS PERMISOS SEGÚN EL ID DEL ROL ACTIVO

        $menuPermisos = "";
        if (count($menuRoles) > 1){
            foreach ($menuRoles as $permisoActual) {
                $menuPermisos .= traerPermisos($permisoActual);
            }
        } elseif(count($menuRoles) === 1){
            $menuPermisos .= traerPermisos($menuRoles[0]);
        }
        $menuCambioRoles = traerCambiosRol($roles);
        $menuDatosUsActivo = traerDatosUs($sesion, $rolActivo);
    } else { // SI NO TIENE NINGÚN ROL
        $menuPermisos = "";
        $menuCambioRoles = traerCambiosRol($roles);
        $menuDatosUsActivo = traerDatosUs($sesion, ['rol' => null]);
    }
} else {
    $menuSinLogin = "<!-- MENÚ NO LOGIN -->
        <li class='nav-item dropdown'>
            <a class='nav-link dropdown-toggle' href='#' role='button' data-bs-toggle='dropdown' aria-expanded='false'>
                <i class='fa-solid fa-right-to-bracket'></i>
            </a>
            <div class='dropdown-menu dropdown-menu-end'>
                <a class='dropdown-item' href='../Login/login.php'>Iniciar Sesión</a>
                <hr class='dropdown-divider'>
                <a class='dropdown-item' href='../Login/registro.php'>Registrarse</a>
            </div>
        </li>";
}


if (isset($menuSinLogin)) {
    $retorno['menuSinLogin'] = $menuSinLogin;
} else {
    $retorno['menuPermisos'] = $menuPermisos;
    $retorno['menuCambioRoles'] = $menuCambioRoles;
    $retorno['menuDatosUsActivo'] = $menuDatosUsActivo;
}

echo json_encode($retorno);

function traerPermisos($menuRol)
{
    $abmMenu = new abmMenu();
    $permisos = "";
    $objMenuActual = $menuRol->getObjMenu(); // TRAEMOS EL OBJ MENU
    if (!empty($objMenuActual->getObjMenuPadre())) { //VERIFICA SI ES RAIZ OSEA IDPADRE=NULL
        $idMenuActual = $objMenuActual->getID(); //TOMA EL ID DE LA RAIZ
        $retorno = $abmMenu->tieneHijos($idMenuActual);  // SI TIENE HIJOS RETORNA ARREGLO, SINO NULL
        if ($retorno <> null) { // VERIFICAMOS

            $padreConHijos = "<!-- INICIO PERMISOS DROPDOWN --><li class='nav-item dropdown me-2'>
                <a class='nav-link dropdown-toggle text-white' href='#' role='button' data-bs-toggle='dropdown' aria-expanded='false'>" . $objMenuActual->getMeNombre() . "</a>
                <div class='dropdown-menu dropdown-menu-end'>";

            $hijos = "";
            foreach ($retorno as $menuRolHijo) { // RECORREMOS LOS HIJOS
                $hijos .= "<a class='dropdown-item' href=" . $menuRolHijo->getMeDescripcion() . ">" . $menuRolHijo->getMeNombre() . "</a>";
            }

            $padreConHijos .= $hijos;
            $permisos .= $padreConHijos . "</div></li><!-- FIN PERMISOS DROPDOWN -->";
        }
    } else {
        $padreSinHijos = "<a class='dropdown-item' href=" . $objMenuActual->getMeDescripcion() . ">" . $objMenuActual->getMeNombre() . "</a>";
    }


    if (isset($padreConHijos)) {
        $permisos = $padreConHijos;
    }
    if (isset($padreSinHijos)) {
        $permisos = $padreSinHijos;
    }

    return $permisos;
}

function traerCambiosRol($roles)
{

    if (count($roles) > 1) { //SI TIENE MAS DE UN ROL
        $cambiosRol = "<!-- INICIO CAMBIAR ROLES --><li class='nav-item dropdown'>
        <a class='nav-link dropdown-toggle text-white' href='#' role='button' data-bs-toggle='dropdown' aria-expanded='false'>
            <i class='fa-solid fa-user-gear me-1'></i>Cambiar Roles</a>
        <div class='dropdown-menu dropdown-menu-end'>";
        $rolsito = "";
        foreach ($roles as $rolActual) {
            $rolsito .= "<button class='cambiarRol dropdown-item'>" . strtoupper($rolActual->getRolDescripcion()) . "</button>";
        }

        $cambiosRol .= $rolsito;
        $cambiosRol .= "</div></li><!-- FIN CAMBIAR ROLES -->";
    } elseif (count($roles) === 1) { //SI TIENE UN SOLO ROL
        switch ($roles[0]->getRolDescripcion()) {
            case 'cliente':
                $cambiosRol = "<li class='nav-item'>
                <a class='nav-link active' aria-current='page' href='#'><i class='fa-solid fa-user-tie me-2'></i>Cliente</a></li>";
                break;
            case 'deposito':
                $cambiosRol = "<li class='nav-item'>
                <a class='nav-link active' aria-current='page' href='#'><i class='fa-solid fa-user-ninja me-2'></i>Deposito</a></li>";
                break;
            case 'admin':
                $cambiosRol = "<li class='nav-item'>
                <a class='nav-link active' aria-current='page' href='#'><i class='fa-solid fa-user-astronaut me-2'></i>Admin</a></li>";
                break;
        }
    } else { // SI NO TIENE ROLES
        $cambiosRol = "<li class='nav-item'>
        <a class='nav-link active' aria-current='page' href='#'><i class='fa-solid fa-skull me-2'></i>No tienes Permisos</a></li>";
    }

    return $cambiosRol;
}

function traerDatosUs($sesion, $rolActivo)
{
    $nombreUsuario = $sesion->getNombreUsuarioLogueado();

    $menuUs = "<!-- INICIO USUARIO ACTIVO DATOS -->
            <button class='btn btn-outline-dark dropdown-toggle' type='button' data-bs-toggle='dropdown' aria-expanded='false'>
                <i class='fa-solid fa-user me-2'></i>" . $nombreUsuario . "</button>
            <ul class='dropdown-menu'><li><a class='dropdown-item' id='rolactivo' disabled='disabled'>
            <i class='fa-solid fa-address-book me-2'></i>";

    if ($rolActivo['rol'] === null) {
        $cartel = "ROL: NO";
    } else {
        $cartel = "ROL: " . strtoupper($rolActivo['rol']);
    }
    $menuUs .= $cartel;
    $menuUs .= "</a></li><hr class='dropdown-divider'>";

    $clienteActivo = "";

    if ($rolActivo['rol'] === 'cliente' || $rolActivo['rol'] === null) {
        $clienteActivo = "<li><a class='dropdown-item' href='../Cliente/modificarPerfil.php'><i class='fa-solid fa-user-pen me-2'></i>Ver Perfil</a></li>
                <hr class='dropdown-divider'>";
    }
    $menuUs .= $clienteActivo;
    $menuUs .= "<li><a class='dropdown-item' href='../Login/accion/cerrarSesion.php'><i class='fa-solid fa-power-off me-2'></i>Cerrar Sesión</a></li></ul><!-- FIN MENÚ USUARIO LOGEADO -->";

    return $menuUs;
}
