<?php
$Titulo = "Carrito";
include_once './Estructura/cabecera.php';
if (!$sesion->verificarPermiso('./carrito.php')) {
    $mensaje = "No tiene permiso para acceder a este sitio.";
    echo "<script> window.location.href='../Home/index.php?mensaje=" . urlencode($mensaje) . "'</script>";
} else {
?>
    <div class="container py-5 text-center">

        <div class="row align-items-start">

            <div class="table-responsive col-9" id="estructuraCarrito">

                <table class="table table-hover caption-top align-middle text-center" id="tablaCarrito">

                </table>
                <!--FIN TABLE-->

            </div><!--FIN ESTRUCTURA CARRITO-->
            <div class="col-3 align-self-start" id="totalPagar">

            </div><!--FIN TOTAL A PAGAR-->

        </div><!--FIN FILA DE ITEMS-->

    </div><!--FIN CONTAINER-->


<?php } ?>
<script src="..\Utiles\js\funcionesCarrito.js"></script>
<?php include_once '.\Estructura\pie.php'; ?>