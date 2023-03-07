<?php
$Titulo = "Tabla Usuarios";
include_once './Estructura/cabecera.php';
if (!$sesion->verificarPermiso('./tablaUsuarios.php')) {
    $mensaje = "No tiene permiso para acceder a este sitio.";
    echo "<script> window.location.href='./index.php?mensaje=" . urlencode($mensaje) . "'</script>";
} else {
    $objUsuarios = new abmUsuario();
    $listaUsuario = $objUsuarios->buscar(null);
    $objRol = new abmRol();
    $listaRoles = $objRol->buscar(null);
    if (count($listaUsuario) > 0) {
?>
        <div class="container my-2">
            <div class="table-responsive">
                <table class="table table-hover caption-top align-middle text-center" id="tablaUsuarios">

                    <thead class="table-dark">
                        <tr>
                            <th width="70">ID</th>
                            <th>Nombre</th>
                            <th>Mail</th>
                            <th>Deshabilitado</th>
                            <th width="125">Roles</th>
                            <th width="425">Acciones</th>
                        </tr>
                        <tr class="table-active">
                            <td><input class="form-control" type="number" placeholder="#" readonly></td>
                            <td><input class="form-control" type="text" placeholder="Nombre"></td>
                            <td><input class="form-control" type="text" placeholder="Mail"></td>
                            <td><input class="form-control" type="text" placeholder="null" readonly></td>
                            <td>
                                <select class="form-control">
                                    <?php foreach($listaRoles as $rol){ ?>
                                    <option value=<?php echo $rol->getID() ?>><?php echo $rol->getRolDescripcion() ?></option>
                                    <?php } ?>
                                </select>
                            </td>
                            <td>
                                <a href="#" class="agregar">
                                    <button class="btn btn-outline-success"><i class="fa-solid fa-folder-plus me-2"></i>Agregar</button>
                                </a>
                            </td>
                        </tr>
                    </thead>
                    <tbody class="table-group-divider">
                        <!-- AQUI SE AÑADEN LOS USUARIOS DINÁMICAMENTE -->
                    </tbody>
                </table>
            </div>

            
        </div>

        <script src="../Utiles/js/funcionesABMUsuario.js"></script>
        <script src="../Utiles/js/md5.js"></script>
    <?php } else {
    ?>
        <div class="container p-2">
            <div class="alert alert-info" role="alert">
                No hay usuarios cargados!
            </div>
        </div>
<?php
    }
    include_once '.\Estructura\pie.php';
} ?>