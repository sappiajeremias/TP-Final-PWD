<?php
$Titulo = "Tabla Compras";
include_once '../Estructura/cabecera.php';
if (!$sesion->verificarPermiso('../Deposito/tablaCompras.php')) {
    $mensaje = "No tiene permiso para acceder a este sitio.";
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
        <div class="container my-2">
            <div class="table-responsive">
                <table class="table table-hover caption-top align-middle text-center" id="tablaCompras">
                    <caption>Compras</caption>
                    <thead class="table-dark">
                        <tr>
                            <th>ID CE</th>
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

            <!-- AQUI SE LISTAN LOS PRODUCTOS -->
            <div class="position-fixed top-50 start-50 translate-middle">
                <div class="container-fluid p-4 mt-5 border border-2 rounded-2 bg-light shadow-lg p-3 mb-5 d-none" id='oculto'>
                    <h5 id="usnombre" class="text-center"></h5>
                    <hr>
                    <div class="overflow-auto" style="height: 300px;">
                        <ol class="list-group" id="listaProductos">
                        </ol>
                    </div>
                    <button type="button" class="btn btn-outline-danger mt-2" id="cerrar"><i class="fa-solid fa-xmark me-2"></i>Cerrar</button>
                </div>
            </div>

            <script src="../../Utiles/js/funcionesABMCompras.js"></script>
        </div>
    <?php } else {
    ?>
        <div class="container py-4">
            <div class="alert alert-info" role="alert">
                No hay compras registradas
            </div>
        </div>
<?php
    }
    include_once '../Estructura/pie.php';
} ?>