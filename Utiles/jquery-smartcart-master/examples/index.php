<?php
include_once '../../../configuracion.php';
$abmProductos = new abmProducto();
$listaProductos = $abmProductos->buscarConStock();
?>
<!DOCTYPE html>
<html>

<head>
    <title>jQuery Smart Cart - The smart interactive jQuery Shopping Cart plugin with PayPal payment support</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Iconos Libreria -->
    <script src="../../Iconos/FontAwesomeKit.js"></script>

    <!-- Include Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css">

    <!-- Include SmartCart CSS -->
    <link href="../dist/css/smart_cart.min.css" rel="stylesheet" type="text/css" />
</head>

<body>
    <div class="container">
        <div class="row">
            <?php
            foreach ($listaProductos as $productoActual) {
            ?>
                <div class="col-sm-3 pb-3">
                    <div class="sc-product-item">
                        <div class="card">
                            <div class="card-body text-center">
                                <h4 name="product_id" class="card-title"><?php echo $productoActual->getID(); ?></h4>
                                <h5 data-name="product_name" class="card-title"><?php echo $productoActual->getProNombre(); ?></h5>
                                <p name="product_price" class="card-text"><?php echo $productoActual->getProDetalle(); ?></p>
                                <p class="card-text"><b>Stock Actual:</b> <?php echo $productoActual->getProCantStock(); ?></p>
                            </div>
                            <button class="sc-add-to-cart btn btn-success btn-sm pull-right">Agregar al Carrito</button>
                        </div>
                    </div>
                </div>
            <?php } ?>
        </div>
        <div class="container" id="smartcart"></div>
        <a href="paypal.php">Carrito</a>

    </div>
    <br />
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" type="text/javascript"></script>
    <!-- Include jQuery -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.1/jquery.min.js" integrity="sha512-aVKKRRi/Q/YV+4mjoKBsE4x3H+BkegoM/em46NNlCqNTmUYADjBbeNefNxYV7giUp0VxICtqdrbqU7iVaeZNXA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script> <!-- Include SmartCart -->
    <script src="../dist/js/jquery.smartCart.js" type="text/javascript"></script>
    <!-- Initialize -->
    <script type="text/javascript">
        $(document).ready(function() {
            // Initialize Smart Cart    	
            $('#smartcart').smartCart();
        });
    </script>
</body>

</html>