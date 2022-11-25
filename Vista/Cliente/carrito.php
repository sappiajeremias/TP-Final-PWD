<?php
$Titulo = "Carrito";
include_once '../Estructura/cabecera.php';
if ($_SESSION['rolactivodescripcion'] <> 'cliente') { //CHEQUEO USER LOGUEADO
    $mensaje = "No tiene permiso de cliente para acceder a este sitio.";
    echo "<script> window.location.href='../Home/index.php?mensaje=" . urlencode($mensaje) . "'</script>";
    //FIN USER CHEQUEADO
} else {
    $objAbmUsuario = new abmUsuario();
    $objAbmCompraItem = new abmCompraItem();
    $compraCarrito = $objAbmUsuario->obtenerCarrito($sesion->getIDUsuarioLogueado());
    if ($compraCarrito <> null) {
        $paramCompra['idcompra'] = $compraCarrito->getID();
        $eltosCarrito = $objAbmCompraItem->buscar($paramCompra);
        if (count($eltosCarrito) > 0) { ?>
            <div class="table-responsive">
                <table class="table table-hover caption-top" id="tablaCarrito">
                    <caption>Carrito de compras</caption>
                    <thead class="table-dark">
                        <tr>
                            <th>Productos</th>
                            <th>Precio</th>
                            <th>Cantidad</th>
                            <th>Subtotal</th>
                            <th>Eliminar</th>
                        </tr>
                    </thead>
                    <tbody class="table-group-divider">
                        <?php
                        $totalAPagar=0;
                        foreach ($eltosCarrito as $objCompraItem) {
                            $idCompraEstado = $objCompraItem->getID();
                            $cantProductos = $objCompraItem->getCiCantidad();
                            $precioProducto = $objCompraItem->getObjProducto()->getPrecio();
                            $subTotal = $cantProductos * $precioProducto; 
                            $totalAPagar=$totalAPagar+$subTotal;?>
                            
                            <tr>
                                <td hidden><?php echo $idCompraEstado ?></td>
                                <td><?php echo $objCompraItem->getObjProducto()->getProNombre() ?></td>
                                <td><?php echo $precioProducto ?></td>
                                <td><?php echo $cantProductos ?></td>
                                <td><?php echo $subTotal ?></td>
                                <td><a href="#" class="eliminar"><button class="btn btn-outline-danger"><i class="fa-solid fa-trash mx-2"></i></button></a></td>
                            </tr>
                        <?php
                        }?>
                        <tr>
                        <td>Total a pagar:</td>
                        <td><?php echo $totalAPagar ?></td>
                        <td><a class="pagar" href="#"><button class="btn btn-outline-success col-11">Pagar</button></a></td>
                        </tr>
                        <script src="../../Utiles/js/funcionesCarrito.js"></script>
                        <?php
                    } else { ?>
                        <div class="container p-2">
                            <div class="alert alert-info" role="alert">
                                <h1>Tu carrito est&aacute; vac&iacute;o :(</h1>
                                Podes agregar productos entrando a la secci&oacute;n de productos.
                            </div>
                        </div>
                        <a href="../Home/productos.php"><button class="btn btn-outline-success col-11">Ver productos</button></a>
            </div>
        <?php
                    }
        ?>

        </tbody>
        </table>
        </div>
        <!-- FIN CHEQUEO COMPRAS -->
    <?php } else { ?>
        <div class="container p-2">
            <div class="alert alert-info" role="alert">
                <h1>Tu carrito est&aacute; vac&iacute;o :(</h1>
                Podes agregar productos entrando a la secci&oacute;n de productos.
            </div>
            <a href="../Home/productos.php"><button class="btn btn-outline-success col-11">Ver productos</button></a>
        </div>
    <?php
    }
    ?>
    <script src="../../Utiles/js/funcionesCarrito.js"></script>
<?php
}
include_once '../Estructura/pie.php';
?>