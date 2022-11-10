<?php
$Titulo = "Editar Perfil";
include_once '../Estructura/cabecera.php';

if (isset($_SESSION['usnombre'])) {
    $ambUs = new abmUsuario();
    $arreglo = ['usnombre' => $nombreUsuario, 'idusuario' => $idUsuario];
    $obj = $ambUs->buscar($arreglo);
    $correo = $obj[0]->getUsMail();
    $pass = $obj[0]->getUsPass();

    $datosUser = [
        'idusuario' => $idUsuario,
        'usnombre' => $nombreUsuario,
        'usmail' => $correo,
    ];
}
?>
<div class="container p-4 mt-5 border border-info border-2 rounded-2 bg-primary bg-opacity-10" style="width: 350px;">
    <!-- INICIO FORMULARIO DE EDITAR PERFIL -->
    <form action="../Accion/actualizar.php" name="registro" id="registro" method="post" accept-charset="utf-8">
        <div class="form-group mb-3">
            <label for="usnombre" class="form-label">Nombre de Usuario: </label>
            <input type="text" class="form-control" id="usnombre" name="usnombre" autocomplete="off" value=<?php echo $datosUser['usnombre'] ?>>
        </div>
        <div class="form-group mb-3">
            <label for="usmail" class="form-label">Correo: </label>
            <input type="email" class="form-control" id="usmail" name="usmail" autocomplete="off" value=<?php echo $datosUser['usmail']  ?>>
        </div>
        <div class="form-group mb-3">
            <label for="uspass1" class="form-label">Nueva Contraseña: </label>
            <input type="text" class="form-control" id="uspass1" name="uspass1" autocomplete="off">
        </div>
        <div class="form-group mb-3">
            <label for="uspass2" class="form-label">Confirmar Contraseña: </label>
            <input type="text" class="form-control" id="uspass2" name="uspass2" autocomplete="off">
        </div>
        <input type="text" hidden value=<?php echo $datosUser['idusuario'] ?>>
        <button type="submit" class="btn btn-success">Registrarse</button>
    </form>
    <!-- FIN FORMULARIO EDITAR PERFIL -->
</div>

<?php include_once '../Estructura/pie.php'; ?>