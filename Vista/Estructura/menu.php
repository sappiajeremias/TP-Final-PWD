<!-- NAVBAR INICIO -->

<nav class="navbar navbar-expand-lg navbar-dark bg-primary border rounded">
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
            <ul class="navbar-nav d-flex">
                <?php
                        if(empty($_SESSION['usnombre']) || empty($_SESSION['idusuario']) || empty($_SESSION['usmail']) || empty($_SESSION['usdeshabilitado'])){
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
                            $user = $sesion->getUsuario();
                            $rol = $sesion->getRol();
                            $nombreUsuario =  $user->getUsNombre();
                        ?>
                            <!-- INICIO MENÚ USUARIO LOGEADO -->
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    <?php echo $nombreUsuario ?>
                                </a>
                                <div class="dropdown-menu dropdown-menu-end">
                                    <?php
                                        switch ($rol->getIdRol()){
                                            case '1':
                                                ?> <a class="dropdown-item" disabled="disabled"><i class="fa-solid fa-scroll mx-"></i> Rol: Admin</a> <?php
                                                break;
                                            case '2':
                                                ?> <a class="dropdown-item" disabled="disabled"><i class="fa-solid fa-scroll mx-"></i> Rol: Cliente</a> <?php
                                            break;
                                            case '3':
                                                ?> <a class="dropdown-item" disabled="disabled"><i class="fa-solid fa-scroll mx-"></i> Rol: Depósito</a> <?php
                                            break;
                                        } 
                                    ?>
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