<?php
$Titulo = "Tabla Roles";
include_once '../Estructura/cabecera.php';
if ($_SESSION['rolactivodescripcion'] <> 'admin') {
    $mensaje = "No tiene permiso de admin para acceder a este sitio.";
    echo "<script> window.location.href='../Home/index.php?mensaje=" . urlencode($mensaje) . "'</script>";
} else {
    $objRoles = new abmRol();
    $listaRoles = $objRoles->buscar(null);
    
    if (count($listaRoles) > 0) {
?>
        <div class="table-responsive">
            <table class="table table-hover caption-top" id="tablaRoles">
                
                <thead class="table-dark">
                    <tr>
                        <th width="70">ID</th>
                        <th>Descripcion</th>
                        <th width="50">Editar</th>
                        <th width="50">Eliminar</th>
                    </tr>
                </thead>
                <tbody class="table-group-divider">
                    <tr  class="table-success">
                        <td><input class="form-control" type="number" placeholder="#" readonly></td>
                        <td><input class="form-control" type="text" placeholder="Descripcion"></td>
                        <td colspan="2"><a href="#" class="agregar"><button class="btn btn-outline-success col-11"><i class="fa-solid fa-folder-plus"></i></button></a></td>
                    </tr>
                    <?php
                    foreach ($listaRoles as $objR) {
                    ?>
                        <tr>
                            <td><?php echo $objR->getID() ?></td>
                            <td><?php echo $objR->getRolDescripcion() ?></td>
                            
                            <td><a href="#" class="editar"><button class="btn btn-outline-warning"><i class="fa-solid fa-file-pen mx-2"></i></button></a></td>
                            <td><a href="#" class="eliminar"><button class="btn btn-outline-danger"><i class="fa-solid fa-trash mx-2"></i></button></a></td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>

        <div class="position-absolute top-50 start-50 translate-middle">
            <div class="container-fluid p-4 mt-5 border border-2 rounded-2 bg-light d-none" style="width: 350px;" id='editarRol'>
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
       
        <script src="../../Utiles/funcionesABMRol.js"></script>
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