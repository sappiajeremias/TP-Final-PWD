<div class="modal fade" id="editar-modal-imagen" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Editar Imagen</h5>
            </div>
            <div class="modal-body">
                <form enctype="multipart/form-data" name="editarImagen" id="editarImagen" class="row g-3">
                    <input type="text" id="url" name="url" readonly hidden>
                    <input type="number" id="idproducto" name="idproducto" readonly hidden>
                    <div class="form-group col-md-8">
                        <label for="imagen" class="form-label">Nueva imagen para el producto: </label>
                        <input type="file" class="form-control" id="imagen" name="imagen">
                    </div>
                    <div class="form-group col-md-12 d-flex flex-row-reverse">
                        <button type="submit" class="btn btn-outline-warning">Editar</button>
                        <button type="button" class="btn btn-outline-danger mx-2" data-bs-dismiss="modal" aria-label="Close">Cancelar</button>
                    </div>
                </form>
            </div>
            </form>
        </div>
    </div>
</div>