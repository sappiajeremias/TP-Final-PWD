<?php
$Titulo = "Inicio";
include_once '../Estructura/cabecera.php';
$datos = data_submitted();
if(!empty($datos['mensaje'])){
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
            Listado de ALGUNOS productos
        </div>
    </div>


<?php include_once '../Estructura/pie.php'; ?>