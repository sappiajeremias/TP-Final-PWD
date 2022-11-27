<?php
$Titulo = "Tabla Menu Roles";
include_once '../Estructura/cabecera.php';

if ($sesion->esAdmin()) {
    $mensaje = "No tiene permiso de administrador para acceder a este sitio.";
    echo "<script> window.location.href='../Home/index.php?mensaje=" . urlencode($mensaje) . "'</script>";
} else {
    $obj_ABM_Menu = new abmMenu();
    $arrayMenu = $obj_ABM_Menu->buscar(null);

    if (count($arrayMenu) > 0) { ?>
        <div class="container my-2">
            <div class="table-responsive">
                <table class="table table-hover caption-top align-middle text-center" id="tablaMenu">

                    <thead class="table-dark">
                        <tr>
                            <th width="70">ID</th>
                            <th>Nombre</th>
                            <th>Detalle</th>
                            <th width="120">ID Padre</th>
                            <th>Deshabilitado</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody class="table-group-divider">
                        <tr class="table-success">
                            <td><input class="form-control" type="number" placeholder="#" readonly></td>
                            <td><input class="form-control" type="text" placeholder="Nombre"></td>
                            <td><input class="form-control" type="text" placeholder="Detalle"></td>
                            <td><input class="form-control" type="number" min=0 placeholder="ID Menu Padre"></td>
                            <td><input class="form-control" type="text" placeholder="Deshabilitado" onlyread></td>
                            <td colspan="2"><a href="#" class="agregar"><button class="btn btn-outline-success col-11"><i class="fa-solid fa-folder-plus"></i></button></a></td>
                        </tr>
                        <?php
                        foreach ($arrayMenu as $objMenu) {
                            if ($objMenu->getMeDescripcion() === "#") { ?>
                                <tr>
                                    <td><?php echo $objMenu->getID() ?></td>
                                    <td><?php echo $objMenu->getMeNombre() ?></td>
                                    <td><?php echo $objMenu->getMeDescripcion() ?></td>
                                    <td><?php echo "" ?></td>
                                    <td><?php echo $objMenu->getMeDeshabilitado() ?></td>
                                    <td>
                                        <a href="#" class="editar"><button class="btn btn-outline-warning"><i class="fa-solid fa-file-pen mx-2"></i></button></a>
                                        <a href="#" class="eliminar"><button class="btn btn-outline-danger"><i class="fa-solid fa-trash mx-2"></i></button></a>
                                    </td>
                                </tr>
                                <?php }

                            $objHijos_Menu = $obj_ABM_Menu->tieneHijos($objMenu->getID());
                            if ($objHijos_Menu <> null) {

                                foreach ($objHijos_Menu as $value) { ?>
                                    <tr>
                                        <td><?php echo $value->getID() ?></td>
                                        <td><?php echo $value->getMeNombre() ?></td>
                                        <td><?php echo $value->getMeDescripcion() ?></td>
                                        <td><?php echo $objMenu->getID() ?></td>
                                        <td><?php echo $value->getMeDeshabilitado() ?></td>
                                        <td>
                                            <a href="#" class="editar"><button class="btn btn-outline-warning"><i class="fa-solid fa-file-pen mx-2"></i></button></a>
                                            <a href="#" class="eliminar"><button class="btn btn-outline-danger"><i class="fa-solid fa-trash mx-2"></i></button></a>
                                        </td>
                                    </tr>
                        <?php
                                }
                            } else {
                            }
                        }
                        ?>
                    </tbody>
                </table>
            </div>

            <div class="position-fixed top-50 start-50 translate-middle">
                <div class="container-fluid p-4 mt-5 border border-2 rounded-2 bg-light shadow-lg p-3 mb-5 d-none" d-none style="width: 350px;" id='editarMenu'>
                    <h5 class="text-center"><i class="fa-solid fa-file-pen me-2"></i>Actualizar Producto</h5>
                    <hr>
                    <form action="../accion/editarMenu.php" method="post" name="editarP" id="editarM" accept-charset="utf-8" class="mb-3">
                        <div class="form-group mb-3">
                            <div class="col-lg-7 col-12" id='mostrarId'></div>
                            <label for="idmenu" class="form-label">ID: </label>
                            <input type="number" class="form-control" id="idmenu" name="idmenu" readonly>
                        </div>
                        <div class="form-group mb-3">
                            <label for="menombre" class="form-label">Nombre del Menu: </label>
                            <input type="text" class="form-control" id="menombre" name="menombre" autocomplete="off">
                        </div>
                        <div class="form-group mb-3">
                            <label for="medescripcion" class="form-label">Descripción del Menu: </label>
                            <input type="text" class="form-control" id="medescripcion" name="medescripcion" autocomplete="off">
                        </div>

                        <div class="form-group mb-3">
                            <label for="medeshabiltado" class="form-label">Deshabilitado: </label>
                            <input type="text" class="form-control" id="medeshabilitado" name="medeshabilitado" autocomplete="off">
                        </div>
                        <div class="form-group mb-3 ">

                            <label for="idpadre" class="form-label">Menu Padre </label>
                            <input type="text" class="form-control" id="idpadre" name="idpadre" autocomplete="off">

                        </div>
                        <button class="btn btn-outline-warning" type="submit" name="boton_enviar" id="boton_enviar">Modificar</button>
                        <button class="btn btn-outline-danger mx-2" name="cancelar" type="button" id="cancelar">Cancelar</button>
                    </form>
                </div>
            </div>
            <script src="../../Utiles/js/funcionesABMMenu.js"></script>
        </div>
    <?php } else { ?>
        <div class="container p-2">
            <div class="alert alert-info" role="alert">
                No hay menuroles cargados
            </div>
        </div>
<?php  }
}
include_once '../Estructura/pie.php'; ?>
<?php

// Relacionar cada menu con un rol, modificar la relacion menurol

?>