/*################################# CARGAR COMPRAS #################################*/

$(window).on("load", function () {
    cargarCompras();
});

function cargarCompras(){
    $.ajax({
        type: "POST",
        url: './accion/listarCompras.php',
        data: null,
        success: function (response) {
            var arreglo = [];
            $.each($.parseJSON(response), function (index, value) {
                $.each(value, function (index, compraActual) {
                    arreglo.push(compraActual);
                });
            });

            armarTabla(arreglo);
        }
    });
}

// Buscamos la tabla y añadimos cada compra
function armarTabla(arreglo) {
    $('#tablaCompras > tbody:last-child').empty();

    $.each(arreglo, function (index, compra) {
        var botones = null;
        var estadoVista = null;
        //BOTONES ACCIONES SEGÚN SI ES EL ÚLTIMO ESTADO
        if (compra.finfecha == null || compra.finfecha == "0000-00-00 00:00:00") {
            switch (compra.estado) {
                case "iniciada":
                    botones = "<td><a href='#' id='aceptarCompra' class='me-2' onclick='cambiarEstado(2, this.id)'><button class='btn btn-outline-success'><i class='fa-solid fa-check me-2'></i>Aceptar</button></a><a href='#' id='cancelarCompra' onclick='cambiarEstado(4, this.id)'><button class='btn btn-outline-danger'><i class='fa-solid fa-xmark me-2'></i>Cancelar</button></a></td>";
                    break;
                case "aceptada":
                    botones = "<td><a href='#' id='enviarCompra' onclick='cambiarEstado(3, this.id)'><button class='btn btn-outline-info'><i class='fa-solid fa-truck-fast me-2'></i>Enviar</button></a></td>";
                    break;
                case "cancelada":
                case "enviada":
                    botones = "<td>-</td>";
                    break;
            }
        } else {
            botones = "<td>-</td>";
        }

        // BADGE SEGÚN ESTADO
        switch (compra.estado) {
            case "iniciada":
                estadoVista = "<span class='badge rounded-pill text-bg-primary'>Iniciada</span>";
                break;
            case "aceptada":
                estadoVista = "<span class='badge rounded-pill text-bg-success'>Aceptada</span>";
                break;
            case "enviada":
                estadoVista = "<span class='badge rounded-pill text-bg-warning'>Enviada</span>";
                break;
            case "cancelada":
                estadoVista = "<span class='badge rounded-pill text-bg-danger'>Cancelada</span>";
                break;
        }
        $('#tablaCompras > tbody:last-child').append('<tr><td style="display:none;">' + compra.idcompraestado + '</td><th scope="row">' + compra.idcompra + '</th><td>' + compra.usnombre + '</td><td><a href="#" class="verProductos"><button class="btn btn-outline-info col-8"><i class="fa-solid fa-list-ul mx-2"></i></button></a></td><td>' + estadoVista + '</td><td>' + compra.cofecha + '</td><td>' + compra.finfecha + '</td>' + botones + '</tr>');
    });
}

/*################################# VER PRODUCTOS DE COMPRA #################################*/

$(document).on('click', '.verProductos', function () {

    var fila = $(this).closest('tr');
    var idcompra = fila[0].children[1].innerHTML;
    var pronombre = fila[0].children[2].innerHTML;


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
            var dialog = bootbox.dialog({
                message: '<div class="text-center"><i class="fa fa-spin fa-spinner me-2"></i>Listando Productos...</div>',
                closeButton: false
            });
            dialog.init(function () {
                setTimeout(function () {
                    listaProductos(arreglo, pronombre);
                    bootbox.hideAll();
                }, 1000);
            });
        }
    });

});

function listaProductos(arreglo, nombre) {
    document.getElementById('oculto').classList.remove('d-none');
    $('h5').append('<i class="fa-regular fa-rectangle-list me-2"></i>Lista Productos Compra de <b><u>' + nombre + '</u></b>');
    $.each(arreglo, function (index, producto) {
        $('#listaProductos').append('<li class="list-group-item d-flex justify-content-between align-items-start"><div class="row g-0"><div class="col-md-4"><img src="..." class="img-fluid rounded-start" alt="..."></div><div class="col-md-8"><div class="card-body"><h5 class="card-title">' + producto.pronombre + '</h5><p class="card-text">' + producto.prodetalle + '</p><p class="card-text"><small class="text-muted">$ ' + producto.precio + '</small></p></div></div></div><h5><span class="badge text-bg-warning rounded-pill">Cantidad: ' + producto.procantstock + '</span></h5></li>');
    });
};

//CIERRA LA LISTA
$(document).on('click', '#cerrar', function () {
    $('h5').empty();
    $("#listaProductos").empty();
    document.getElementById('oculto').classList.add('d-none');
});

/*################################# CAMBIAR ESTADO COMPRA #################################*/

function cambiarEstado(idcompraestadotipo, idboton) {
    console.log('#' + idboton);
    var fila = $('#' + idboton + '').closest('tr');
    var idcompraestado = fila[0].children[0].innerHTML;
    var idcompra = fila[0].children[1].innerHTML;

    $.ajax({
        type: "POST",
        url: './accion/modificarEstadoCompra.php',
        data: { idcompraestado: idcompraestado, idcompra: idcompra, idcompraestadotipo: idcompraestadotipo },
        success: function (response) {
            var response = jQuery.parseJSON(response);
            if (response.respuesta) {
                // CARTEL LIBRERIA, ESPERA 1 SEG Y LUEGO HACE EL RELOAD
                var dialog = bootbox.dialog({
                    message: '<div class="text-center"><i class="fa fa-spin fa-spinner me-2"></i>Modificando Estado Compra...</div>',
                    closeButton: false
                });
                dialog.init(function () {
                    setTimeout(function () {
                        cargarCompras();
                        bootbox.hideAll();
                    }, 1000);
                });
            } else {
                // ALERT LIBRERIA
                bootbox.alert({
                    message: "No se pudo eliminar el producto!",
                    size: 'small',
                    closeButton: false,
                });
            }
        }
    });
}