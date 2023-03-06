<?php
$Titulo = "Tabla Productos";
include_once './Estructura/cabecera.php';
if (!$sesion->verificarPermiso('./tablaProductos.php')) {
    $mensaje = "No tiene permiso para acceder a este sitio.";
    echo "<script> window.location.href='./index.php?mensaje=" . urlencode($mensaje) . "'</script>";
} else {
?>
    <!-- INCLUIMOS MODALES -->
    <?php include './Estructura/Modales/Productos/modal_add_producto.php'; ?>
    <?php include './Estructura/Modales/Productos/modal_editar_producto.php'; ?>
    <?php include './Estructura/Modales/Productos/modal_editar_imagen.php'; ?>
    
    <div class="container my-2">
        <div class="table-responsive">
            <table class="table table-hover caption-top align-middle text-center" id="tablaProductos">
                <caption>Productos</caption>
                <thead class="table-dark">
                    <tr>
                        <th width="70">ID</th>
                        <th>Nombre</th>
                        <th>Detalle</th>
                        <th>Stock</th>
                        <th>Precio</th>
                        <th>Imagen</th>
                        <th>Deshabilitado</th>
                        <th width="200">Acciones</th>
                    </tr>
                    <tr class="table-active">
                        <td>-</td>
                        <td>-</td>
                        <td>-</td>
                        <td>-</td>
                        <td>-</td>
                        <td>-</td>
                        <td>-</td>
                        <td><button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#agregar-modal-producto">Agregar Producto</button></td>
                    </tr>
                </thead>
                <tbody class="table-group-divider">
                </tbody>
            </table>
        </div>
        <script src="../Utiles/js/funcionesABMProducto.js"></script>
    </div>
<?php
    include_once '.\Estructura\pie.php';
} ?>