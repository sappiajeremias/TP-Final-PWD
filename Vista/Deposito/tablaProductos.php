<?php
$Titulo = "Tabla Productos";
include_once '../Estructura/cabecera.php';
if ($_SESSION['rolactivodescripcion'] <> 'deposito') {
    $mensaje = "No tiene permiso de deposito para acceder a este sitio.";
    echo "<script> window.location.href='../Home/index.php?mensaje=" . urlencode($mensaje) . "'</script>";
} else {
    $objItems = new abmProducto();
    $listaProds = $objItems->buscar(null);
    if (count($listaProds) > 0) {
?>
        <div class="table-responsive">
            <table class="table table-hover caption-top" id="tablaProductos">
                <caption>Productos</caption>
                <thead class="table-dark">
                    <tr>
                        <th width="70">ID</th>
                        <th>Nombre</th>
                        <th>Detalle</th>
                        <th>Stock</th>
                        <th>Precio</th>
                        <th width="50">Editar</th>
                        <th width="50">Eliminar</th>
                    </tr>
                </thead>
                <tbody class="table-group-divider">
                </tbody>
            </table>
        </div>

        <div class="position-absolute top-50 start-50 translate-middle">
            <div class="container-fluid p-4 mt-5 border border-2 rounded-2 bg-light bg-light shadow-lg p-3 mb-5 d-none" id='editarProducto'>
                <h5 class="text-center"><i class="fa-solid fa-file-pen me-2"></i>Actualizar Producto</h5>
                <hr>
                <form action="../accion/editarProd.php" class="row g-3" method="post" name="editarP" id="editarP" accept-charset="utf-8" class="mb-3">
                    <div class="form-group col-md-6">
                        <div class="col-lg-7 col-12" id='mostrarId'></div>
                        <label for="idproducto" class="form-label">ID: </label>
                        <input type="number" class="form-control" id="idproducto" name="idproducto" readonly>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="pronombre" class="form-label">Nombre del Producto: </label>
                        <input type="text" class="form-control" id="pronombre" name="pronombre" autocomplete="off">
                    </div>
                    <div class="form-group col-md-6">
                        <label for="prodetalle" class="form-label">Descripción del Producto: </label>
                        <input type="text" class="form-control" id="prodetalle" name="prodetalle" autocomplete="off">
                    </div>
                    <div class="form-group col-md-6">
                        <label for="procantstock" class="form-label">Stock: </label>
                        <input type="number" class="form-control" id="procantstock" name="procantstock" autocomplete="off">
                    </div>
                    <div class="form-group col-md-6">
                        <label for="precio" class="form-label">Precio: </label>
                        <input type="number" class="form-control" id="precio" name="precio" autocomplete="off">
                    </div>
                    <div class="col-md-12 text-center">
                        <button class="btn btn-outline-warning" type="submit" name="boton_enviar" id="boton_enviar">Modificar</button>
                        <button class="btn btn-outline-danger mx-2" name="cancelar" type="button" id="cancelar">Cancelar</button>
                    </div>
                </form>
            </div>
        </div>
        <script src="../../Utiles/js/funcionesABMProducto.js"></script>
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