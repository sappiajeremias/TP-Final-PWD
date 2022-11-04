<!doctype html>

<html lang="es">
<head>
    <title><?php echo $Titulo?></title>
    
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- CSS de Bootstrap -->
    <link rel="stylesheet" href="../../vista/css/bootstrap/bootstrap.min.css">
    <link rel="stylesheet" href="../../vista/css/bootstrap/bootstrapValidator.min.css">    
    
    <?php 
    include_once("../../configuracion.php"); 
    $sesion = new Session;
    

    ?>
</head>
<body class="container my-3">
    <?php include_once("../estructura/menu.php"); ?>
<!-- Fin cabecera -->