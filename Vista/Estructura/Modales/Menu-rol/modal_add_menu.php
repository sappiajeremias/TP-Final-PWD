<div class="modal fade" id="agregar-modal-menu" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Agregar Menú</h5>
            </div>
            <div class="modal-body">
                <form name="agregar" id="agregar" class="row g-3">
                    <div class="form-group col-md-6">
                        <label for="menombre" class="form-label">Nombre del Menu: </label>
                        <input type="text" class="form-control" id="menombre" name="menombre" autocomplete="off">
                    </div>
                    <div class="form-group col-md-6">
                        <label for="medescripcion" class="form-label">Seleccionar Permiso:</label>
                        <select class="form-select" id="idrol" name="medescripcion" aria-label="Default select example">
                            <option selected disabled>Elegir...</option>
                            <option value="./tablaMenuRoles.php">Tabla Menu-Roles</option>
                            <option value="./tablaRoles.php">Tabla Roles</option>
                            <option value="./tablaUsuarios.php">Tabla Usuarios</option>
                            <option value="./carrito.php">Ver Carrito</option>
                            <option value="./listaCompras.php">Ver Compras</option>
                            <option value="./modificarPerfil.php">Ver Perfil </option>
                            <option value="./tablaCompras.php">Tabla Compras</option>
                            <option value="./tablaProductos.php">Tabla Productos</option>
                        </select>
                    </div>
                    <div class="form-group col-md-12">
                        <label for="idrol" class="form-label">Seleccionar Rol:</label>
                        <select class="form-select" id="idrol" name="idrol" aria-label="Default select example">
                            <option selected disabled>Elegir...</option>
                            <?php
                            $abmRoles = new abmRol();
                            $roles = $abmRoles->buscar(null);
                            foreach ($roles as $rol) { ?>
                                <option value=<?php echo $rol->getID() ?>><?php echo $rol->getRolDescripcion() ?></option>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="form-group col-md-12 d-flex flex-row-reverse">
                        <button type="submit" class="btn btn-outline-warning">Cargar</button>
                        <button type="button" class="btn btn-outline-danger mx-2" data-bs-dismiss="modal" aria-label="Close">Cancelar</button>
                    </div>
                </form>
            </div>
            </form>
        </div>
    </div>
</div>