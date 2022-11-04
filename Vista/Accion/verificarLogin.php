<?php 
include_once("../../Utiles/funciones.php");

$datosIng = data_submitted();
if ( !empty($datosIng) )  {
        $sesion = new Session;
        $sesion->iniciar($datosIng['usnombre']);
        header('Location: ../paginaSegura.php');
    
} //else {
    // Redirige automáticamente si no tiene datos recibidos:
    //header('Location: ../TP5/login.php?no=1');
 ?>