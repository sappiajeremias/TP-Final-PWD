<?php
$Titulo = "Productos";
include_once '../Estructura/cabecera.php';

$abmProductos = new abmProducto();
$listaProductos = $abmProductos->buscar('');
print_r($listaProductos);
?>
    <div class="container p-2">
        <div class="alert alert-warning" role="alert">
            Aqui estarian listados TODOS los productos
        </div>

        <?php foreach($listaProductos as $productoActual){
            echo $productoActual->getID();
            echo $productoActual->getProNombre();
            echo $productoActual->getProDetalle();
            echo $productoActual->getProCantStock();
        } ?>
    </div>

<?php include_once '../Estructura/pie.php'; ?>