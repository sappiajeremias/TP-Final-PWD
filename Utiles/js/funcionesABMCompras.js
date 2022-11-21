
/*################################# VER PRODUCTOS #################################*/

$(document).on('click', '.verProductos', function () {

    var fila = $(this).closest('tr');
    var idcompra = fila[0].children[0].innerHTML;
    var pronombre = fila[0].children[1].innerHTML;


    $.ajax({
        type: "POST",
        url: './accion/listarProdCompra.php',
        data: { idcompra: idcompra },
        success: function (response) {
            arreglo = [];
            $.each($.parseJSON(response), function (index, value) {
                $.each(value, function (index, productoActual) {
                    arreglo.push(productoActual);
                });
            });
            listaProductos(arreglo, pronombre);
        }
    });
   
});

function listaProductos(arreglo, nombre) {
    document.getElementById('oculto').classList.remove('d-none');
    $('h5').append('<i class="fa-regular fa-rectangle-list me-2"></i>Lista de Productos de <b><u>'+nombre+'</u></b>');
    $.each(arreglo, function (index, producto) {
        $('#listaProductos').append('<li class="list-group-item d-flex justify-content-between align-items-start"><div class="row g-0"><div class="col-md-4"><img src="..." class="img-fluid rounded-start" alt="..."></div><div class="col-md-8"><div class="card-body"><h5 class="card-title">'+producto.pronombre+'</h5><p class="card-text">'+producto.prodetalle+'</p><p class="card-text"><small class="text-muted">$ '+producto.precio+'</small></p></div></div></div><h4><span class="badge bg-warning rounded-pill">'+producto.procantstock+'</span></h4></li>');
    });
};

//CIERRA LA LISTA
$(document).on('click', '#cerrar', function () {
    $('h5').empty();
    $("#listaProductos").empty();
    document.getElementById('oculto').classList.add('d-none');
});
