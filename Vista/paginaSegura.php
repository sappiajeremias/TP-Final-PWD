<?php $Titulo= "Pagina Segura";
include_once("../configuracion.php");

if ($sesion->activa())  {
    $mensaje = "<div class='alert alert-success' role='alert'>
        <h5><i class='fas fa-check-circle mx-2'></i>Bienvenido ".$_SESSION['usnombre'].".</h5>
        </div>";
} else {
    $mensaje = "<div class='alert alert-danger' role='alert'>
        <h5><i class='fas fa-times-circle mx-2'></i>No se ha iniciado sesión - <a href='login.php'> Ingrese aquí </a> </h5>
        </div>";
}

echo $mensaje . "<br><br><br>"; 
print_r($sesion);
echo "<br><br><br>";
print_r($_SESSION);
echo "<br><br><br>";
?>