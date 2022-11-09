<?php
$Titulo = "Inicio";
include_once '../Estructura/cabecera.php';
$retorno = data_submitted();

print_r($retorno);
?>
    <div class="container p-2">
        <div class="alert alert-info" role="alert">
            Listado de ALGUNOS productos
        </div>
    </div>


<?php include_once '../Estructura/pie.php'; ?>