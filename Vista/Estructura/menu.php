<?php
if ($sesion->getNombreUsuarioLogueado() <> null) {
    $nombreUsuario = $sesion->getNombreUsuarioLogueado();
    $idUsuario = $sesion->getIDUsuarioLogueado();
    $roles = $sesion->getRoles(); // TODOS LOS ROLES DEL USUARIO ACTIVO
    $abmMenuRol = new abmMenuRol();
    // BUSCAMOS LOS PERMISOS SEGÚN EL ID DEL ROL ACTIVO
    $menuRoles = $abmMenuRol->buscar(['idrol'=>$_SESSION['rolactivoid']]);
    $abmMenu = new abmMenu();
}
?>


<!-- NAVBAR INICIO -->
<nav class="navbar navbar-expand-lg navbar-dark bg-primary border rounded">
    <!-- INCIO MENÚ PÚBLICO -->
    <div class="container-fluid">
        <a class="navbar-brand" href="#">Nombre Sitio</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="../Home/index.php">Inicio</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="../Home/productos.php">Productos</a>
                </li>
            </ul>
        </div>
        <!-- FIN MENÚ PÚBLICO -->
        <ul class="navbar-nav d-flex">
            <?php
            if ($sesion->getNombreUsuarioLogueado() === null) {
            ?>
                <!-- MENÚ NO LOGIN -->
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="fa-solid fa-right-to-bracket"></i>
                    </a>
                    <div class="dropdown-menu dropdown-menu-end">
                        <a class="dropdown-item" href="../Login/login.php">Iniciar Sesión</a>
                        <hr class="dropdown-divider">
                        <a class="dropdown-item" href="../Login/registro.php">Registrarse</a>
                    </div>
                </li>
                <?php
            } else {
                if($_SESSION['rolactivodescripcion'] === 'cliente'){
                    ?>
                        <li class="nav-item">
                            <a class="nav-link text-white" href="../Cliente/carrito.php">
                                <i class="fa-solid fa-cart-shopping">
                                    <span class="top-0 start-100 translate-middle badge rounded-pill bg-warning">2</span>
                                </i>
                            </a>
                        </li>
                    <?php
                }
                foreach ($menuRoles as $menuRolActual) {
                    $objMenuActual = $menuRolActual->getObjMenu(); // TRAEMOS EL MENU ACTUAL
                    if (!empty($objMenuActual->getObjMenuPadre())) { //VERIFICA SI ES RAIZ OSEA IDPADRE=NULL
                        $idMenuActual = $objMenuActual->getID(); //TOMA EL ID DE LA RAIZ
                        $retorno = $abmMenu->tieneHijos($idMenuActual);  // SI TIENE HIJOS RETORNA ARREGLO, SINO NULL
                        if ($retorno <> null) { // VERIFICAMOS
                ?>
                            <li class="nav-item dropdown">
                                <!-- INICIO PERMISOS DROPDOWN -->
                                <a class="nav-link dropdown-toggle text-white" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    <?php echo $objMenuActual->getMeNombre() ?>
                                </a>
                                <div class="dropdown-menu dropdown-menu-end">
                                    <?php
                                    foreach ($retorno as $menuRolHijo) { // RECORREMOS LOS HIJOS
                                    ?>
                                        <a class="dropdown-item" href=<?php echo $menuRolHijo->getMeDescripcion(); ?>> <?php echo $menuRolHijo->getMeNombre(); ?></a>
                                <?php
                                    }
                                } ?>
                                </div></li></ul><!-- FIN PERMISOS DROPDOWN -->
    <?php
                    } else { ?>
        <a class="dropdown-item" href=<?php echo $objMenuActual->getMeDescripcion(); ?>>
            <?php echo $objMenuActual->getMeNombre(); ?>
        </a>
    <?php
                    } ?>
    <!-- INICIO CAMBIAR ROLES --><?php
                                                    } 
if (count($roles)>1){?>
<ul class="navbar-nav d-flex">
    <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle text-white" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false"><i class="fa-solid fa-user-gear me-1"></i>Cambiar Roles</a>
        <div class="dropdown-menu dropdown-menu-end">
            <?php foreach ($roles as $rolActual) { ?>
                <a class="dropdown-item" href="../../Control/controlCambiarRol.php?nuevorol=<?php echo $rolActual->getRolDescripcion() ?>">  <?php echo strtoupper($rolActual->getRolDescripcion()); ?></a>
            <?php } ?>
        </div>
    </li>
</ul>
<!-- FIN CAMBIAR ROLES -->
<?php } ?>
<!-- INICIO USUARIO ACTIVO DATOS -->
<ul class="navbar-nav d-flex text-center">
    <a class="nav-link dropdown-toggle text-white" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false"><i class="fa-solid fa-user me-2"></i><?php echo $nombreUsuario; ?></a>
    <div class="dropdown-menu dropdown-menu-end">
        <a class="dropdown-item" id="rolactivo" disabled="disabled"><i class="fa-solid fa-address-book me-2"></i>ROL: <?php echo strtoupper($_SESSION['rolactivodescripcion']) ?></a>
        <hr class="dropdown-divider">
        <a class="dropdown-item" href="../Login/verPerfilUsuario.php"><i class="fa-solid fa-user-pen me-2"></i>Ver Perfil</a>
        <hr class="dropdown-divider">
        <a class="dropdown-item" href="../Accion/cerrarSesion.php"><i class="fa-solid fa-power-off me-2"></i>Cerrar Sesión</a>
    </div>
</ul>
<!-- FIN MENÚ USUARIO LOGEADO -->
<?php } ?>
    </div>
    </div>
</nav>
<!-- NAVBAR FIN -->