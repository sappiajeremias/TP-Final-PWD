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
    <form action="results.php" method="POST">
        <!-- SmartCart element -->
        <div id="smartcart"></div>
    </form>
    </div>
    <br />
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" type="text/javascript"></script>
    <!-- Include jQuery -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.1/jquery.min.js" integrity="sha512-aVKKRRi/Q/YV+4mjoKBsE4x3H+BkegoM/em46NNlCqNTmUYADjBbeNefNxYV7giUp0VxICtqdrbqU7iVaeZNXA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script> <!-- Include SmartCart -->
    <script src="../dist/js/jquery.smartCart.js" type="text/javascript"></script>
    <!-- Initialize -->
    <script type="text/javascript">
        var carrito = sessionStorage.getItem('carro');
        console.log(carrito);
        $(document).ready(function() {
            // Initialize Smart Cart    	
            $('#smartcart').smartCart();
        });
    </script>
</body>

</html>