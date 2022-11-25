<?php
$Titulo = "Tabla Compras";
include_once '../Estructura/cabecera.php';
if ($sesion->esCliente()) {
    $mensaje = "No tiene permiso de cliente para acceder a este sitio.";
    echo "<script> window.location.href='../Home/index.php?mensaje=" . urlencode($mensaje) . "'</script>";
} else {
    $objItems = new abmCompra();
    $listaCompras = $objItems->buscar(['idusuario' => $_SESSION['idusuario']]);

    if (count($listaCompras) > 0) {
?>
        <div class="container my-2">
            <div class="table-responsive">
                <table class="table table-hover caption-top align-middle text-center" id="tablaCompras">

                    <thead class="table-dark">
                        <tr>
                            <th>ID CE</th>
                            <th>Usuario</th>
                            <th>Productos lista</th>
                            <th>Estado</th>
                            <th>Fecha Inicio</th>
                            <th>Fecha Fin</th>
                        </tr>
                    </thead>
                    <tbody class="table-group-divider">
                    </tbody>
                </table>
            </div>

            <!-- AQUI SE LISTAN LOS PRODUCTOS -->
            <div class="position-absolute top-50 start-50 translate-middle">
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

            <script src="../../Utiles/js/funcionesABMListadoCompras.js"></script>
        </div>
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