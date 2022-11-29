<?php
$Titulo = "Carrito";
include_once '../Estructura/cabecera.php';
if ($sesion->esCliente()) {
    $mensaje = "No tiene permiso de cliente para acceder a este sitio.";
    echo "<script> window.location.href='../Home/index.php?mensaje=" . urlencode($mensaje) . "'</script>";

} else {
    ?>
            <div class="table-responsive col-9" id="estructuraCarrito">
                <table class="table table-hover caption-top align-middle text-center" id="tablaCarrito">
                    <!-- ACA SE LISTAN LOS TH DE LA TABLA CON JQUERY-->
                </table>
                
                <!-- ACA SE LISTAN LOS PRODUCTOS DEL CARRITO CON JQUERY-->
        </div>
        <div id="totalPagar">
                    
                </div>
        
    <?php } ?>
    <script src="../../Utiles/js/funcionesCarrito.js"></script>
<?php

include_once '../Estructura/pie.php';
?>