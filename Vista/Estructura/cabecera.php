<!DOCTYPE html>
<html lang="es">
<head>
    <title><?php echo $Titulo?></title>
    
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- VALIDACIONES ESTILOS -->
    <link rel="stylesheet" href="../../Utiles/validaciones.css">

    <!-- BOOTSTRAP -->
    <link rel="stylesheet" href="../../Utiles/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="../../Utiles/bootstrap/css/bootstrapValidator.min.css">

    
    <!-- JQUERY -->
    <script type="text/javascript" src="../../Utiles/jquery-3.6.1/jquery.min.js"></script>
    
    <!-- Iconos Libreria -->
    <script src="../../Utiles/Iconos/FontAwesomeKit.js"></script>
    
    <!-- ICON -->
    <link rel="icon" type="image/x-icon" href="./img/icon.ico">

    <?php
        include_once '../../configuracion.php';
        $sesion = new Session();
    ?>
</head>
<?php  include_once("../../Vista/Estructura/menu.php") ?>
<!-- FIN CABECERA -->

<body class="container my-3">