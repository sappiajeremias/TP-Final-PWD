<?php
if(!(isset($_SESSION['usnombre']))){
    $sesion = new Session();
    $nombreUsuario = $sesion->getNombreUsuarioLogueado();
    $idUsuario = $sesion->getIDUsuarioLogueado();
    $roles = $sesion->getRoles(); // TODOS LOS ROLES DEL USUARIO ACTIVO
    $rolActivoID =  $_SESSION['rolactivoid']; //ID DEL ROL
    $rolActivoDesc =  $_SESSION['rolactivo']; //DESCRIPCION DEL ROL

    $abmMenuRol = new abmMenuRol();
    $menus = $abmMenuRol->buscar($rolActivoID);
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
                        if(!(isset($_SESSION['usnombre']))){
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
                        ?>
                            <!-- INICIO MENÚ USUARIO LOGEADO -->
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle text-white" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="fa-solid fa-user mx-2"></i><?php echo "ROL ACTIVO: ".$rolActivo ?>
                                </a>
                                <!-- hacemos la relacion con menu y rolActivo para traer los botones correspondientes -->
                                <div class="dropdown-menu dropdown-menu-end">
                                    <?php
                                    //recorremos los menues varios
                                        foreach($menus as $menuActual){
                                            ?><a class="dropdown-item" disabled="disabled" href=<?php echo $menuActual->getMeDescripcion() ?> > <?php echo $menuActual->getMeNombre() ?></a>
                                            <hr class="dropdown-divider">
                                            <?php
                                        }
                                    ?>
                                </div>
                            </li>
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle text-white" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="fa-solid fa-user mx-2"></i><?php echo $nombreUsuario ?>
                                </a>
                                <div class="dropdown-menu dropdown-menu-end">
                                    <?php
                                        foreach($roles as $rolActual){
                                            ?><a class="dropdown-item" disabled="disabled"><i class="fa-solid fa-scroll mx-"></i> Rol: <?php echo $rolActual->getRolDescripcion() ?></a><?php
                                        }
                                    ?>
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