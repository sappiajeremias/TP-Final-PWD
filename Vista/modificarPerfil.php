<?php
$Titulo = "Editar Perfil";
include_once './Estructura/cabecera.php';
if (!$sesion->verificarPermiso('./modificarPerfil.php')) {
    $mensaje = "No tiene permiso para acceder a este sitio.";
    echo "<script> window.location.href='./index.php?mensaje=" . urlencode($mensaje) . "'</script>";
} else {
    if ($sesion->getNombreUsuarioLogueado() <> null) {
        $datosUser = [
            'idusuario' => $sesion->getIDUsuarioLogueado(),
            'usnombre' => $sesion->getNombreUsuarioLogueado(),
            'usmail' => $sesion->getMailUsuarioLogueado()
        ];
?>
        <!-- MD5 -->
        <script src="..\Utiles\js\md5.js"></script>
        <!--VALIDADOR -->
        <script src="..\Utiles\js\validaciones.js"></script>
        <!-- VALIDACIONES ESTILOS -->
        <link rel="stylesheet" href="..\Utiles\validaciones.css">

        <div class="container p-4 mt-5 border border-info border-2 rounded-2 bg-primary bg-opacity-10" style="width: 350px;">
            <!-- INICIO FORMULARIO DE EDITAR PERFIL -->
            <form class="needs-validation" novalidate action="./accion/actualizar.php" name="modificar" id="modificar" method="post" accept-charset="utf-8">
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
                    <input type="password" class="form-control" id="uspass1" name="uspass1" autocomplete="off" required>
                </div>
                <div class="form-group mb-3">
                    <label for="uspass2" class="form-label">Confirmar Contraseña: </label>
                    <input type="password" class="form-control" id="uspass2" name="uspass2" autocomplete="off" required>
                </div>
                <input type="text" id="idusuario" name="idusuario" hidden value=<?php echo $datosUser['idusuario'] ?>>
                <button type="submit" class="btn btn-success">Modificar</button>
            </form>
            <!-- FIN FORMULARIO EDITAR PERFIL -->
        </div>

        <script src="..\Utiles\js\modificar.js"></script>

<?php include_once '.\Estructura\pie.php';
    } else {
        $mensaje = "No estas logeado";
        echo "<script> window.location.href='../Home/index.php?mensaje=" . urlencode($mensaje) . "'</script>";
    }
}
