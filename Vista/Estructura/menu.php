<?php
if (!(isset($_SESSION['usnombre']))) {
    $sesion = new Session();
    $nombreUsuario = $sesion->getNombreUsuarioLogueado();
    $idUsuario = $sesion->getIDUsuarioLogueado();
    $roles = $sesion->getRoles(); // TODOS LOS ROLES DEL USUARIO ACTIVO

    $rolActivoID =  1; //ID DEL ROL
    $rolActivoDesc =  'admin'; //DESCRIPCION DEL ROL

    $abmMenuRol = new abmMenuRol();
    $menuRoles = $abmMenuRol->buscar($rolActivoID);
    
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
            <!-- FIN MENÚ PÚBLICO -->
            <ul class="navbar-nav d-flex">
                <?php
                if (!(isset($_SESSION['usnombre']))) {
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
                        foreach ($menuRoles as $menuRolActual) {
                            $objMenuActual = $menuRolActual->getObjMenu();
                            if (!empty($objMenuActual->getObjMenuPadre())) { //VERIFICA SI ES RAIZ
                                $idMenuPadre = $objMenuActual->getID(); //TOMA EL ID DE LA RAIZ
                                if ($abmMenu->tieneHijos($idMenuPadre)) { //VERFICA SI TIENE HIJOS
                            ?>
                            <li class="nav-item dropdown"> <!-- PERMISOS DROPDOWN INICIO -->
                                <a class="nav-link dropdown-toggle text-white" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    <?php echo $objMenuActual->getMeNombre() ?>
                                </a>
                            <div class="dropdown-menu dropdown-menu-end">
                            <?php
                                foreach ($menuRoles as $menuRolHijo) { // BUSCAMOS A SUS HIJOS
                                    $menuHijo = $menuRolHijo->getObjMenu();
                                    $objPadre = $menuHijo->getObjMenuPadre();
                                    $idObjPadre = $objPadre->getID();
                                    echo $idObjPadre."  AAAAAAAAAAAAA ".$idMenuPadre;
                                    if ($idObjPadre === $idMenuPadre) {
                            ?>
                                <a class="dropdown-item" href=<?php echo $menuRolHijo->getMeDescripcion(); ?> > <?php echo $menuRolHijo->getMeNombre(); ?></a>
                                <hr class="dropdown-divider">
                            <?php
                                    }
                                }?>
                            </div>
                            </li><!-- PERMISOS DROPDOWN FIN -->
                                <?php
                                } else {?>
                                    <a class="dropdown-item" href=<?php echo $objMenuActual->getMeDescripcion(); ?> >
                                        <?php echo $objMenuActual->getMeNombre(); ?>
                                    </a>
                            <?php
                                }?>
                            </div><!-- INICIO MENÚ PERMISOS SEGÚN EL ROL ACTIVO --><?php
                            }
                        }?>
                        <!-- INICIO USUARIO ACTIVO DATOS -->
                        <div>
                            <li class="nav-item dropdown">
                                <a class="dropdown-item" href="#">
                                    <i class="fa-solid fa-user mx-2"></i><?php echo "ROL ACTIVO: " . $rolActivoDesc; ?>
                                </a>
                            </li>
                        </div>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle text-white" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="fa-solid fa-user mx-2"></i><?php echo $nombreUsuario; ?>
                        </a>
                        <div class="dropdown-menu dropdown-menu-end">
                            <?php foreach($roles as $rolActual){?>
                                <a class="dropdown-item" disabled="disabled"><i class="fa-solid fa-scroll mx-"></i> Rol: <?php echo $rolActual->getRolDescripcion(); ?></a>
                            <?php } ?>
                            <hr class="dropdown-divider">
                            <a class="dropdown-item" href="../Accion/verPerfilUsuario.php">Ver Perfil</a>
                            <hr class="dropdown-divider">
                            <a class="dropdown-item" href="../Accion/cerrarSesion.php">Cerrar Sesión</a>
                        </div>
                    </li>
                    <!-- FIN MENÚ USUARIO LOGEADO -->
                <?php } ?>
            </ul>
        </div>
    </div>
</nav>
<!-- NAVBAR FIN -->