<?php
$Titulo = "Iniciar Sesion";
include_once '../Estructura/cabecera.php';
?>
<div class="container p-4 mt-5 border border-info border-2 rounded-2 bg-primary bg-opacity-10" style="width: 350px;">
    <h5 class="text-center"><i class="fa-solid fa-person-arrow-up-from-line me-2"></i>Iniciar Sesion</h5>
    <hr>
    <!-- INICIO FORMULARIO INICIAR SESIÓN -->
    <form action="" method="post" name="login" id="login" accept-charset="utf-8" class="mb-3">
        <div class="form-group mb-3" >
            <label for="usnombre" class="form-label">Nombre de Usuario: </label>
            <input type="text" class="form-control" id="usnombre" name="usnombre" autocomplete="off">
        </div>
        <div class="form-group mb-3">
            <label for="uspass" class="form-label">Contraseña: </label>
            <input type="password" class="form-control" id="uspass" name="uspass" autocomplete="off">
        </div>
        <button type="submit" class="btn btn-primary">Ingresar</button>
    </form>
    <!-- FIN FORMULARIO INICIAR SESIÓN -->
    <div class="p3">
        No est&aacute; registrado?
        <a href="registro.php">Registrarse</a>
    </div>
</div>

<script src="../../Utiles/js/funcionesLogin.js"></script>

<?php include_once '../Estructura/pie.php'; ?>