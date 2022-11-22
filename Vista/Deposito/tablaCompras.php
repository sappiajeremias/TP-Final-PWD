<?php
$Titulo = "Tabla Compras";
include_once '../Estructura/cabecera.php';
if ($_SESSION['rolactivodescripcion'] <> 'deposito') {
    $mensaje = "No tiene permiso de deposito para acceder a este sitio.";
    echo "<script> window.location.href='../Home/index.php?mensaje=" . urlencode($mensaje) . "'</script>";
    // Ver las compras generadas por los clientes
    // Cambiar el estado de las compras
    // EN CADA CAMBIO DE ESTADO SE LE DEBE NOTIFICAR AL USUARIO
    // ACEPTADA (SE RESTA EL STOCK DE ESE CARRITO A TODOS LOS PRODUCTOS CORRESPONDIENTES)
    // CANCELADA (RECHAZA EL CARRITO DEL CLIENTE, NO OCURRE NADA MAS ALLA DEL CAMBIO DE ESTADO DE LA COMPRA)
    // ENVIADA (CAMBIO DE ESTADO)
} else {
    $objItems = new abmCompra();
    $listaCompras = $objItems->buscar(null);
    if (count($listaCompras) > 0) {
?>
        <div class="table-responsive">
            <table class="table table-hover caption-top" id="tablaCompras">
                <caption>Compras</caption>
                <thead class="table-dark">
                    <tr>
                        <th>ID</th>
                        <th>Usuario</th>
                        <th>Productos lista</th>
                        <th>Estado</th>
                        <th>Fecha Inicio</th>
                        <th>Fecha Fin</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody class="table-group-divider">
                </tbody>
            </table>
        </div>

        <div class="position-absolute top-50 start-50 translate-middle">
            <div class="container-fluid p-4 mt-5 border border-2 rounded-2 bg-light d-none" id='oculto'>
                <h5 class="text-center"></h5>
                <hr>
                <ol class="list-group" style="width: 400px;" id="listaProductos">
                    <!--<li class="list-group-item d-flex justify-content-between align-items-start">
                        <div class="row g-0">
                            <div class="col-md-4">
                                <img src="..." class="img-fluid rounded-start" alt="...">
                            </div>
                            <div class="col-md-8">
                                <div class="card-body">
                                    <h5 class="card-title">Card title</h5>
                                    <p class="card-text">This is a wider card with supporting text below as a natural lead-in to additional content.</p>
                                    <p class="card-text"><small class="text-muted">Last updated 3 mins ago</small></p>
                                </div>
                            </div>
                        </div>
                        <span class="badge bg-primary rounded-pill">14</span>
                    </li>-->
                </ol>
                <button type="button" class="btn btn-outline-danger mt-2" id="cerrar"><i class="fa-solid fa-xmark me-2"></i>Cerrar</button>
            </div>
        </div>

        <script src="../../Utiles/js/funcionesABMCompras.js"></script>
    <?php } else {
    ?>
        <div class="container p-2">
            <div class="alert alert-info" role="alert">
                No hay productos cargados
            </div>
        </div>
<?php
    }
    include_once '../Estructura/pie.php';
} ?>