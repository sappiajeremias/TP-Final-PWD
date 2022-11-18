<?php
$Titulo = "Inicio";
include_once '../Estructura/cabecera.php';
$datos = data_submitted();
if (!empty($datos['mensaje'])) {
?>
    <div class='container pt-3 text-center'>
        <div class='alert alert-warning alert-dismissible fade show' role='alert'>
            <i class='fa-solid fa-check mx-2'></i> <?php echo $datos['mensaje'] ?>
            <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
        </div>
    </div>
<?php } ?>
<div class="container p-2">
    <div class="alert alert-info" role="alert">
        Orden Estados de Compra
    </div>
</div>
<nav style="--bs-breadcrumb-divider: '->';" aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><span class="badge rounded-pill text-bg-light">Borrador (Carrito)</span></li>
        <li class="breadcrumb-item"><span class="badge rounded-pill text-bg-success">Iniciado (Solicitud Compra)</span></li>
        <li class="breadcrumb-item"><span class="badge rounded-pill text-bg-warning">Aceptado (Resto Stock)</span></li>
        <li class="breadcrumb-item"><span class="badge rounded-pill text-bg-info">Enviado (Email Notificación)</span></li>

    </ol>
</nav>
<nav style="--bs-breadcrumb-divider: '->';" aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><span class="badge rounded-pill text-bg-light">Borrador (Carrito)</span></li>
        <li class="breadcrumb-item"><span class="badge rounded-pill text-bg-success">Iniciado (Solicitud Compra)</span></li>
        <li class="breadcrumb-item"><span class="badge rounded-pill text-bg-danger">Cancelado</span></li>

    </ol>
</nav>


<?php include_once '../Estructura/pie.php'; ?>