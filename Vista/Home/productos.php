<?php
$Titulo = "Productos";
include_once '../Estructura/cabecera.php';

$abmProductos = new abmProducto();
$listaProductos = $abmProductos->buscar('');
?>
    <div class="container p-2">
        <div class="alert alert-warning" role="alert">
            Aqui estarian listados TODOS los productos
        </div>
        <div class="row">
        <?php foreach($listaProductos as $productoActual){
            ?>
                <div class="col-sm-3 pb-3">
                    <div class="card">
                        <div class="card-body text-center">
                            <h4 class="card-title"><?php echo $productoActual->getID(); ?></h4>
                            <h5 class="card-title"><?php echo $productoActual->getProNombre(); ?></h5>
                            <p class="card-text"><?php echo $productoActual->getProDetalle(); ?></p>
                            <p class="card-text"><b>Stock Actual:</b> <?php echo $productoActual->getProCantStock(); ?></p>
                        </div>
                        <div class="d-grid gap-2 d-md-block m-auto mb-2">
                            <button type="button" class="btn btn-primary btn-sm">Añadir al carrito</button>
                            <button type="button" class="btn btn-success btn-sm">Comprar Ahora</button>
                        </div>
                    </div>
                </div>
            <?php
        } ?>
        </div>
    </div>

<?php include_once '../Estructura/pie.php'; ?>