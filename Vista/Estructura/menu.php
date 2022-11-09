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
                    <a class="nav-link active" aria-current="page" href="../Cliente/listadoProductos.php">Productos</a>
                </li>
            </ul>
            <ul class="navbar-nav d-flex">
                <!-- SI LA SESIÓN NO ESTA ACTIVA -->
                <?php
                        if(empty($_SESSION['usnombre']) || empty($_SESSION['idusuario']) || empty($_SESSION['usmail']) || empty($_SESSION['usdeshabilitado'])){
                            ?>
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="fa-solid fa-right-to-bracket"></i>
                                </a>
                                <ul class="dropdown-menu">
                                    <li><a class="dropdown-item" href="../Login/login.php">Iniciar Sesión</a></li>
                                    <li><hr class="dropdown-divider"></li>
                                    <li><a class="dropdown-item" href="../Login/registro.php">Registrarse</a></li>
                                </ul>
                            </li>
                            <?php
                            // SI LA SESIÓN ESTA ACTIVA
                        } else {
                            $user = $sesion->getUsuario();
                            $rol = $sesion->getRol();
                            $nombreUsuario =  $user->getUsNombre();
                        ?>
                            <li class="nav-item">
                            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <?php
                                    echo $nombreUsuario;
                                ?>
                            </a>
                            <ul class="dropdown-menu">
                                <?php
                                    switch ($rol->getIdRol()){
                                        case '1':
                                            ?> <li><a class="dropdown-item" disabled="disabled"><i class="fa-solid fa-user mx-2"></i> Rol: Admin</a></li> <?php
                                            break;
                                        case '2':
                                            ?> <li><a class="dropdown-item" disabled="disabled"><i class="fa-solid fa-user mx-2"></i> Rol: Cliente</a></li> <?php
                                        break;
                                        case '3':
                                            ?> <li><a class="dropdown-item" disabled="disabled"><i class="fa-solid fa-user mx-2"></i> Rol: Depósito</a></li> <?php
                                        break;
                                    } 
                                ?>
                                <li>
                                    <hr class="dropdown-divider">
                                </li>
                                <li><a class="dropdown-item" href="../Accion/cerrarSesion.php">Cerrar Sesión</a></li>
                            </ul>
                            </li>
                    <?php } ?>
                </ul>
        </div>
    </div>
</nav>
<!-- NAVBAR FIN -->