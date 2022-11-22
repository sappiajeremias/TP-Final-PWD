/*################################# CARGAR COMPRAS #################################*/

$(window).on("load", function () {
    $.ajax({
        type: "POST",
        url: './accion/listarCompras.php',
        data: null,
        success: function (response) {
            console.log(response)
            var arreglo = [];
            $.each($.parseJSON(response), function (index, value) {
                $.each(value, function (index, compraActual) {
                    arreglo.push(compraActual);
                });
            });

            armarTabla(arreglo);
        }
    });
});

// Buscamos la tabla y añadimos cada compra
function armarTabla(arreglo) {
    $.each(arreglo, function (index, compra) {
        var botones = null;
        var estadoVista = null;
        // Por cada estado preparamos botones para realizar distintas acciones o ninguna
        switch (compra.estado) {
            case "iniciada":
                estadoVista = "<span class='badge text-bg-primary'>Iniciada</span>";
                botones = "<td colspan='2'><a href='#' class='aceptarCompra me-2'><button class='btn btn-outline-success'><i class='fa-solid fa-check me-2'></i>Aceptar</button></a><a href='#' class='cancelarCompra'><button class='btn btn-outline-danger'><i class='fa-solid fa-xmark me-2'></i>Cancelar</button></a></td>";
                break;
            case "aceptada":
                estadoVista = "<span class='badge text-bg-success'>Aceptada</span>";
                botones = "<td colspan='2'><a href='#' class='enviarCompra'><button class='btn btn-outline-info'<i class='fa-solid fa-truck-ramp-box me-2'></i>Enviar</button></a></td>";
                break;
            case "enviada":
                estadoVista = "<span class='badge text-bg-warning'>Enviada</span>";
                botones = "<td colspan='2'>No hay acciones</td>";
                break;
            case "cancelada":
                estadoVista = "<span class='badge text-bg-danger'>Cancelada</span>";
                botones = "<td colspan='2'>No hay acciones</td>";
                break;
        }

        $('#tablaCompras > tbody:last-child').append('<tr><td>'+compra.idcompra+'</td><td>'+compra.usnombre+'</td><td><a href="#" class="verProductos"><button class="btn btn-outline-info col-8"><i class="fa-solid fa-list-ul mx-2"></i></button></a></td><td>'+estadoVista+'</td><td>'+compra.cofecha+'</td><td>'+compra.finfecha+'</td>'+botones+'</tr>');
    });
}

/*################################# VER PRODUCTOS DE COMPRA #################################*/

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
    $('h5').append('<i class="fa-regular fa-rectangle-list me-2"></i>Lista Productos Compra de <b><u>' + nombre + '</u></b>');
    $.each(arreglo, function (index, producto) {
        $('#listaProductos').append('<li class="list-group-item d-flex justify-content-between align-items-start"><div class="row g-0"><div class="col-md-4"><img src="..." class="img-fluid rounded-start" alt="..."></div><div class="col-md-8"><div class="card-body"><h5 class="card-title">' + producto.pronombre + '</h5><p class="card-text">' + producto.prodetalle + '</p><p class="card-text"><small class="text-muted">$ ' + producto.precio + '</small></p></div></div></div><h5><span class="badge bg-warning rounded-pill">Cantidad: ' + producto.procantstock + '</span></h5></li>');
    });
};

//CIERRA LA LISTA
$(document).on('click', '#cerrar', function () {
    $('h5').empty();
    $("#listaProductos").empty();
    document.getElementById('oculto').classList.add('d-none');
});
