<?php
$Titulo = "Tabla Menu Roles";
include_once './Estructura/cabecera.php';

if (!$sesion->verificarPermiso('./tablaMenuRoles.php')) {
    $mensaje = "No tiene permiso para acceder a este sitio.";
    echo "<script> window.location.href='./index.php?mensaje=" . urlencode($mensaje) . "'</script>";
} else {
    $abmMenu = new abmMenu();
    $abmMR = new abmMenuRol();
    $list = $abmMR->buscar(null);

    if (count($list) > 0) { ?>
        <!-- INCLUIMOS MODALES -->
        <?php include './Estructura/Modales/Menu-rol/modal_add_menu.php'; ?>
        <?php include './Estructura/Modales/Menu-rol/modal_add_hijo.php'; ?>

        <div class="container my-2">
            <div class="table-responsive">
                <table class="table table-hover caption-top align-middle text-center" id="tablaMenu">
                    <thead class="table-dark">
                        <tr>
                            <th width="70">ID</th>
                            <th>ID Padre</th>
                            <th>Nombre</th>
                            <th>Detalle</th>
                            <th width="120">Rol</th>
                            <th>Acciones</th>
                        </tr>
                        <tr class="table-active">
                            <td>-</td>
                            <td>-</td>
                            <td>-</td>
                            <td>-</td>
                            <td>-</td>
                            <td><button type="button" class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#agregar-modal-menu">Agregar Menú</button></td>
                        </tr>
                    </thead>
                    <tbody class="table-group-divider">
                    </tbody>
                </table>
            </div>

            <script src="../Utiles/js/funcionesABMMenu.js"></script>
        </div>
    <?php } else { ?>
        <div class="container p-2">
            <div class="alert alert-info" role="alert">
                No hay menuroles cargados
            </div>
        </div>
<?php  }
}
include_once '.\Estructura\pie.php'; ?>