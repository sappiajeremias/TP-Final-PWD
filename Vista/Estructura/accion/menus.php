<?php
include_once '../../../configuracion.php';
$sesion = new Session();

if ($sesion->sesionActiva()) {
    $rolActivo = $sesion->getRolActivo(); // ARREGLO CON ID Y DESCRIPCION DEL ROL ACTIVO
    $roles = $sesion->getRoles(); // TODOS LOS OBJ ROLES DEL USUARIO ACTIVO

    $abmMenuRol = new abmMenuRol();
    $menuRoles = $abmMenuRol->buscar(['idrol' => $rolActivo['id']]); // BUSCAMOS LOS PERMISOS SEGÚN EL ID DEL ROL ACTIVO

    $menuPermisos = traerPermisos($menuRoles);
    $menuCambioRoles = traerCambiosRol($roles);
    $menuDatosUsActivo = traerDatosUs($sesion, $rolActivo);
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

function traerPermisos($menuRoles)
{
    $abmMenu = new abmMenu();

    foreach ($menuRoles as $menuRolActual) {
        $objMenuActual = $menuRolActual->getObjMenu(); // TRAEMOS EL OBJ MENU
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
                $padreConHijos .= "</div></li><!-- FIN PERMISOS DROPDOWN -->";
            }
        } else {
            $padreSinHijos = "<a class='dropdown-item' href=" . $objMenuActual->getMeDescripcion() . ">" . $objMenuActual->getMeNombre() . "</a>";
        }
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

    if (count($roles) > 1) {
        $cambiosRol = "<!-- INICIO CAMBIAR ROLES --><li class='nav-item dropdown'>
        <a class='nav-link dropdown-toggle text-white' href='#' role='button' data-bs-toggle='dropdown' aria-expanded='false'>
            <i class='fa-solid fa-user-gear me-1'></i>Cambiar Roles</a>
        <div class='dropdown-menu dropdown-menu-end'>";
        $rolsito = "";
        foreach ($roles as $rolActual) {
            $rolsito .= "<a class='dropdown-item' href='../../Control/controlCambiarRol.php?nuevorol=" . $rolActual->getRolDescripcion() . "'>" . strtoupper($rolActual->getRolDescripcion()) . "</a>";
        }

        $cambiosRol .= $rolsito;
        $cambiosRol .= "</div></li><!-- FIN CAMBIAR ROLES -->";
    }

    return $cambiosRol;
}

function traerDatosUs($sesion, $rolActivo){
    $nombreUsuario = $sesion->getNombreUsuarioLogueado();

    $menuUs = "<!-- INICIO USUARIO ACTIVO DATOS -->
            <button class='btn btn-outline-dark dropdown-toggle' type='button' data-bs-toggle='dropdown' aria-expanded='false'>
                <i class='fa-solid fa-user me-2'></i>".$nombreUsuario."</button>
            <ul class='dropdown-menu'>
            <li><a class='dropdown-item' id='rolactivo' disabled='disabled'><i class='fa-solid fa-address-book me-2'></i>ROL:".strtoupper($rolActivo['rol'])."</a></li>
            <hr class='dropdown-divider'>";

            $clienteActivo = "";
            if($rolActivo['rol'] === 'cliente') {
                $clienteActivo = "<li><a class='dropdown-item' href='../Cliente/modificarPerfil.php'><i class='fa-solid fa-user-pen me-2'></i>Ver Perfil</a></li>
                <hr class='dropdown-divider'>";
            }
    $menuUs .= $clienteActivo;
    $menuUs .="<li><a class='dropdown-item' href='../Login/accion/cerrarSesion.php'><i class='fa-solid fa-power-off me-2'></i>Cerrar Sesión</a></li></ul><!-- FIN MENÚ USUARIO LOGEADO -->";

    return $menuUs;
}