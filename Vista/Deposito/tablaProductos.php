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
                        <th field="idproducto">ID</th>
                        <th field="pronombre">Nombre</th>
                        <th field="prodetalle">Detalle</th>
                        <th field="procantstock">Stock</th>
                        <th width="50">Editar</th>
                        <th width="50">Eliminar</th>
                    </tr>
                </thead>
                <tbody class="table-group-divider">
                    <?php
                    foreach ($listaProds as $objProd) {
                    ?>
                        <tr>
                            <td><?php echo $objProd->getID() ?></td>
                            <td><?php echo $objProd->getProNombre() ?></td>
                            <td><?php echo $objProd->getProDetalle() ?></td>
                            <td><?php echo $objProd->getProCantStock() ?></td>
                            <td><a href="#" class="editar"><button class="btn btn-outline-warning"><i class="fa-solid fa-file-pen mx-2"></i></button></a></td>
                            <td><a href="#" class="eliminar"><button class="btn btn-outline-danger"><i class="fa-solid fa-trash mx-2"></i></button></a></td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>

        <div class="position-absolute top-40 start-50 translate-middle">
            <div class="container-fluid p-4 mt-5 border border-dark border-2 rounded-2 bg-light d-none" style="width: 350px;" id='editarProducto'>
                <h5 class="text-center"><i class="fa-solid fa-file-pen me-2"></i>Actualizar Producto</h5>
                <hr>
                <form action="../accion/editarProd.php" method="post" name="editarP" id="editarP" accept-charset="utf-8" class="mb-3">
                    <div class="form-group mb-3">
                        <div class="col-lg-7 col-12" id='mostrarId'></div>
                        <label for="idproducto" class="form-label">ID: </label>
                        <input type="number" class="form-control" id="idproducto" name="idproducto" readonly>
                    </div>
                    <div class="form-group mb-3">
                        <label for="pronombre" class="form-label">Nombre del Producto: </label>
                        <input type="text" class="form-control" id="pronombre" name="pronombre" autocomplete="off">
                    </div>
                    <div class="form-group mb-3">
                        <label for="prodetalle" class="form-label">Descripción del Producto: </label>
                        <input type="text" class="form-control" id="prodetalle" name="prodetalle" autocomplete="off">
                    </div>
                    <div class="form-group mb-3">
                        <label for="procantstock" class="form-label">Stock: </label>
                        <input type="text" class="form-control" id="procantstock" name="procantstock" autocomplete="off">
                    </div>
                    <button class="btn btn-outline-warning" type="submit" name="boton_enviar" id="boton_enviar">Modificar</button>
                    <button class="btn btn-outline-danger mx-2" name="cancelar" type="button" id="cancelar">Cancelar</button>
                </form>
            </div>
        </div>

        <script src="../../Utiles/js/producto/editarProducto.js"></script>
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