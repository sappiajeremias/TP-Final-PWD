<!-- NAVBAR INICIO -->
<nav class="navbar navbar-expand-lg navbar-dark bg-primary">
    <!-- INCIO MENÚ PÚBLICO -->
    <div class="container-fluid m-3">
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
                <!--
                            <li class="nav-item">
                                <a class="nav-link text-white" href="../Cliente/carrito.php">
                                    <i class="fa-solid fa-cart-shopping">
                                        <span class="top-0 start-100 translate-middle badge rounded-pill bg-warning">2</span>
                                    </i>
                                </a>
                            </li>
                        -->
            </ul>
        </div>
        <!-- FIN MENÚ PÚBLICO -->
        <ul class="navbar-nav d-flex px-4">
            <div id="sinLogin"></div>
            <div id="listaPermisos"></div>
            <ul class="navbar-nav d-flex me-2" id="listaCambioRol"></ul>
            <div class="dropdown-center" id="listaUs"></div>
        </ul>
    </div>
</nav>
<!-- NAVBAR FIN -->