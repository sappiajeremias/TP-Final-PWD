<div class="modal fade" id="editar-modal-producto" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Editar Producto</h5>
            </div>
            <div class="modal-body">
                <form enctype="multipart/form-data" name="editarForm" id="editarForm" class="row g-3">
                    <div class="form-group col-md-6">
                        <label for="idproducto" class="form-label">ID: </label>
                        <input type="text" class="form-control" id="idproducto" name="idproducto" readonly>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="prodeshabilitado" class="form-label">Deshabilitado: </label>
                        <input type="text" class="form-control" id="prodeshabilitado" name="prodeshabilitado" readonly>
                    </div>
                    <small>El ID es un dato INTOCABLE, puede deshabilitar el producto con el botón de la tabla</small>
                    <div class="form-group col-md-6">
                        <label for="pronombre" class="form-label">Nombre del Producto: </label>
                        <input type="text" class="form-control" id="pronombre" name="pronombre" autocomplete="off">
                    </div>
                    <div class="form-group col-md-6">
                        <label for="prodetalle" class="form-label">Descripción del Producto: </label>
                        <input type="text" class="form-control" id="prodetalle" name="prodetalle" autocomplete="off">
                    </div>
                    <div class="form-group col-md-6">
                        <label for="procantstock" class="form-label">Stock: </label>
                        <input type="number" min="0" class="form-control" id="procantstock" name="procantstock" autocomplete="off">
                    </div>
                    <div class="form-group col-md-6">
                        <label for="precio" class="form-label">Precio: </label>
                        <input type="number" min="0" class="form-control" id="precio" name="precio" autocomplete="off">
                    </div>
                    <input type="text" id="imagen" name="imagen" hidden>
                    <div class="form-group col-md-12 d-flex flex-row-reverse">
                        <button type="submit" class="btn btn-outline-warning ms-2">Editar</button>
                        <button type="button" class="editarImagenButton btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#editar-modal-imagen">Editar imagen</button>
                        <button type="button" class="btn btn-outline-danger me-2" data-bs-dismiss="modal" aria-label="Close">Cancelar</button>
                    </div>
                </form>
            </div>
            </form>
        </div>
    </div>
</div>