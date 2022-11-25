<?php
$Titulo = "Tabla Usuarios";
include_once '../Estructura/cabecera.php';
if ($_SESSION['rolactivodescripcion'] <> 'admin') {
    $mensaje = "No tiene permiso de admin para acceder a este sitio.";
    echo "<script> window.location.href='../Home/index.php?mensaje=" . urlencode($mensaje) . "'</script>";
} else {
    $objUsuarios = new abmUsuario();
    $listaUsuario = $objUsuarios->buscar(null);
    $objRol = new abmRol();
    $listaRoles = $objRol->buscar(null);
    if (count($listaUsuario) > 0) {
?>
        <div class="table-responsive">
            <table class="table table-hover caption-top align-middle text-center" id="tablaUsuarios">
                <caption>Usuarios</caption>
                <thead class="table-dark">
                    <tr>
                        <th width="70">ID</th>
                        <th>Nombre</th>
                        <th>Mail</th>
                        <th>Deshabilitado</th>
                        <th width="125">Roles</th>
                        <th width="425">Acciones</th>
                    </tr>
                </thead>
                <tbody class="table-group-divider">
                    <!-- AQUI SE AÑADEN LOS USUARIOS DINÁMICAMENTE -->
                </tbody>
            </table>
        </div>

        <div class="position-absolute top-50 start-50 translate-middle">
            <div class="container-fluid p-4 mt-5 border border-2 rounded-2 bg-light d-none" style="width: 350px;" id='editarUsuario'>
                <h5 class="text-center"><i class="fa-solid fa-file-pen me-2"></i>Actualizar Usuario</h5>
                <hr>
                <form action="./accion/editarUsuario.php" method="post" name="editarU" id="editarU" accept-charset="utf-8" class="mb-3">
                    <div class="form-group mb-3">
                        <div class="col-lg-7 col-12" id='mostrarId'></div>
                        <h1>Por favor seleccione el rol que desea agregar</h1>
                    </div>
                    <div class="form-group mb-3">
                        <select class="form-control">
                            <?php
                            foreach ($listaRoles as $objR) {
                            ?>
                                <option value=<?php echo $objR->getID() ?>><?php echo $objR->getRolDescripcion() ?></option>
                            <?php } ?>
                        </select>
                    </div>

                    <button class="btn btn-outline-warning" type="submit" name="boton_enviar" id="boton_enviar">Modificar</button>
                    <button class="btn btn-outline-danger mx-2" name="cancelar" type="button" id="cancelar">Cancelar</button>
                </form>
            </div>
        </div>

        <script src="../../Utiles/js/funcionesABMUsuario.js"></script>
    <?php } else {
    ?>
        <div class="container p-2">
            <div class="alert alert-info" role="alert">
                No hay usuarios cargados
            </div>
        </div>
<?php
    }
    include_once '../Estructura/pie.php';
} ?>