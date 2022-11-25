<?php
$Titulo = "Productos";
include_once '../Estructura/cabecera.php';

$abmProductos = new abmProducto();
$listaProductos = $abmProductos->buscarConStock();

?>
<div class="container p-2">
    <div class="alert alert-warning" role="alert">
        Aqui estarian listados TODOS los productos
    </div>
    <?php
    if ($listaProductos <> null) {
    ?>
        <div class="row">
            <?php foreach ($listaProductos as $productoActual) {
            ?>
                <div class="col-sm-3 pb-3">
                    <div class="card">
                        <div class="card-body text-center">
                            
                            <h5 class="card-title"><?php echo $productoActual->getProNombre(); ?></h5>
                            <p class="card-text"><?php echo $productoActual->getProDetalle(); ?></p>
                            <p class="card-text"><b>Stock Actual:</b> <?php echo $productoActual->getProCantStock(); ?></p>
                        </div>
                        <?php if ($sesion->sesionActiva()) {
                            $rolActivo = $sesion->getRolActivo();
                            if ($rolActivo['rol'] === 'cliente') { ?>
                                <div class="d-grid gap-2 d-md-block m-auto mb-2">
                                    <button class="carrito"type="button" onclick=agregarACarrito(<?php echo $productoActual->getID(); ?>) class="agregarACarrito btn btn-primary btn-sm">Añadir al carrito</button>
                                </div>
                                <script src="../../Utiles/js/funcionesCarrito.js"></script>
                                 
                        <?php }
                        } ?>
                    </div>
                </div>
            <?php } ?>
        </div>
    <?php } else { ?>
        <div class="alert alert-danger" role="alert">
            No hay stock de ningún producto, estamos en quiebra :(
        </div>
    <?php } ?>
</div>

<?php include_once '../Estructura/pie.php'; ?>