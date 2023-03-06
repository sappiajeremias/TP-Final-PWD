<?php
$Titulo = "Tabla Roles";
include_once './Estructura/cabecera.php';
if (!$sesion->verificarPermiso('./tablaRoles.php')) {
    $mensaje = "No tiene permiso para acceder a este sitio.";
    echo "<script> window.location.href='./index.php?mensaje=" . urlencode($mensaje) . "'</script>";
} else {
    $objRoles = new abmRol();
    $listaRoles = $objRoles->buscar(null);

    if (count($listaRoles) > 0) {
?>
        <div class="container my-2">
            <div class="table-responsive">
                <table class="table table-hover caption-top align-middle text-center" id="tablaRoles">

                    <thead class="table-dark">
                        <tr>
                            <th width="70">ID</th>
                            <th>Descripcion</th>
                            <th width="150">Acciones</th>
                        </tr>
                    </thead>
                    <tbody class="table-group-divider">
                        <tr class="table-active">
                            <td><input class="form-control" type="number" placeholder="#" readonly></td>
                            <td><input class="form-control" type="text" placeholder="Descripcion"></td>
                            <td><a href="#" class="agregar"><button class="btn btn-outline-success"><i class="fa-solid fa-folder-plus"></i></button></a></td>
                        </tr>
                        <?php
                        foreach ($listaRoles as $objR) {
                        ?>
                            <tr>
                                <td><?php echo $objR->getID() ?></td>
                                <td><?php echo $objR->getRolDescripcion() ?></td>
                                <td>
                                    <a href="#" class="editar"><button class="btn btn-outline-warning"><i class="fa-solid fa-file-pen mx-2"></i></button></a>
                                    <a href="#" class="eliminar"><button class="btn btn-outline-danger"><i class="fa-solid fa-trash mx-2"></i></button></a>
                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>

            <div class="position-fixed top-50 start-50 translate-middle">
                <div class="container-fluid p-4 mt-5 border border-2 rounded-2 bg-light bg-light shadow-lg p-3 mb-5 d-none" style="width: 350px;" id='editarRol'>
                    <h5 class="text-center"><i class="fa-solid fa-file-pen me-2"></i>Editar rol</h5>
                    <hr>
                    <form action="./accion/editarRol.php" method="post" name="editarR" id="editarR" accept-charset="utf-8" class="mb-3">
                        <div class="form-group mb-3">
                            <div class="col-lg-7 col-12" id='mostrarId'></div>
                            <label for="idrol" class="form-label">ID: </label>
                            <input type="number" class="form-control" id="idrol" name="idrol" readonly>
                        </div>
                        <div class="form-group mb-3">
                            <label for="descripcion" class="form-label">Descripción: </label>
                            <input type="text" class="form-control" id="descripcion" name="descripcion" autocomplete="off">
                        </div>

                        <button class="btn btn-outline-warning" type="submit" name="boton_enviar" id="boton_enviar">Modificar</button>
                        <button class="btn btn-outline-danger mx-2" name="cancelar" type="button" id="cancelar">Cancelar</button>
                    </form>
                </div>
            </div>
        </div>

        <script src="../Utiles/js/funcionesABMRol.js"></script>
    <?php } else {
    ?>
        <div class="container p-2">
            <div class="alert alert-info" role="alert">
                No hay roles cargados
            </div>
        </div>
<?php
    }
    Include_once '.\Estructura\pie.php';
} ?>