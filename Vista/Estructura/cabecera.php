<!doctype html>

<html lang="es">
<head>
    <title><?php echo $Titulo?></title>
    
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- VALIDACIONES ESTILOS -->
    <link rel="stylesheet" href="../../utiles/estilosDeposito.css">
    <link rel="stylesheet" href="../../Utiles/validaciones.css">

    <!-- BOOTSTRAP -->
    <link rel="stylesheet" href="../../Utiles/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="../../Utiles/bootstrap/css/bootstrapValidator.min.css">
    
    <!-- Iconos Libreria -->
    <script src="../../Utiles/Iconos/FontAwesomeKit.js"></script>
    
    <!-- ICON -->
    <link rel="icon" type="image/x-icon" href="./img/icon.ico">
    
    <!--JQUERY EASYUI-->
    <link rel="stylesheet" type="text/css" href="../../utiles/jquery/themes/default/easyui.css">
    <link rel="stylesheet" type="text/css" href="../../utiles/jquery/themes/default/linkbutton.css">
    <link rel="stylesheet" type="text/css" href="../../utiles/jquery/themes/default/dialog.css">
    <link rel="stylesheet" type="text/css" href="../../utiles/jquery/themes/default/textbox.css">
    <link rel="stylesheet" type="text/css" href="../../utiles/jquery/themes/default/datagrid.css">
    

    <?php
        include_once '../../configuracion.php';
        $sesion = new Session();
    ?>
</head>
<?php  include_once("../../Vista/Estructura/menu.php") ?>
<!-- FIN CABECERA -->

<body class="container my-3">