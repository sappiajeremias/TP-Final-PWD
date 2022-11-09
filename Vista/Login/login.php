<?php
$Titulo = "Iniciar Sesion";
include_once '../Estructura/cabecera.php';
?>
<div class="container p-4 mt-5 border border-dark border-3 rounded-2 bg-primary bg-opacity-10" style="width: 350px;">
    <h5 class="text-center"><i class="fa-solid fa-person-arrow-up-from-line mx-2"></i>Iniciar Sesion</h5>
    <hr>
    <!-- INICIO FORMULARIO INICIAR SESIÓN -->
    <form action="../Accion/ingresar.php" method="post" name="logeo" id="logeo" accept-charset="utf-8" class="mb-3">
        <div class="form-group mb-3" >
            <label for="usnombre" class="form-label">Nombre de Usuario: </label>
            <input type="text" class="form-control border border-dark border-2" id="usnombre" name="usnombre" autocomplete="off">
        </div>
        <div class="form-group mb-3">
            <label for="uspass" class="form-label">Contraseña: </label>
            <input type="password" class="form-control border border-dark border-2" id="uspass" name="uspass" autocomplete="off">
        </div>
        <input name="remember" value="0" hidden>
        <button type="submit" class="btn btn-primary">Ingresar</button>
    </form>
    <!-- FIN FORMULARIO INICIAR SESIÓN -->
    <div class="p3">
        No est&aacute; registrado?
        <a href="registro.php">Registrarse</a>
    </div>
</div>


<?php include_once '../Estructura/pie.php'; ?>