<?php
$Titulo = "Inicio";
include_once './Estructura/cabecera.php';
$datos = data_submitted();
if (!empty($datos['mensaje'])) {
?>
    <div class="position-fixed p-2 bottom-0 end-0">
        <div class="toast show text-bg-primary">
            <div class="toast-header">
                <i class="fa-solid fa-envelope me-2"></i>
                <strong class="me-auto">Mensaje Sistema</strong>
                <small>hace 2 minutos</small>
                <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
            <div class="toast-body">
                <span><?php echo $datos['mensaje'] ?></span>
            </div>
        </div>
    </div>
<?php } ?>
<div class="container">
    <div class="container p-2">

        <img src="../Vista/img/invernadero.png" class="d-block w-100" alt="...">
    </div>
</div>


<?php include_once './Estructura/pie.php'; ?>