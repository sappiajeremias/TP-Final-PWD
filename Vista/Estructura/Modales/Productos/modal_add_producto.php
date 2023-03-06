<div class="modal fade" id="agregar-modal-producto" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Agregar Producto</h5>
            </div>
            <div class="modal-body">
                <form enctype="multipart/form-data" name="agregar" id="agregar" class="row g-3">
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
                    <div class="form-group col-md-12">
                        <label for="imagen" class="form-label">Imagen del Producto: </label>
                        <input type="file" class="form-control" id="imagen" name="imagen">
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