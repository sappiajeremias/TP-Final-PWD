/*################################# CARGAR COMPRAS #################################*/

$(window).on("load", function () {
    cargarCompras();
});

function cargarCompras(){
    $.ajax({
        type: "POST",
        url: '../Acciones/compra/listadoCompras.php',
        data: null,
        success: function (response) {
            //console.log(response);
            var arreglo = [];
            $.each($.parseJSON(response), function (index, compraActual) {
                
                    arreglo.push(compraActual);
        
            });
            //console.log(arreglo)

            armarTabla(arreglo);
        }
    });
}

// Buscamos la tabla y añadimos cada compra
function armarTabla(arreglo) {

    $('#tablaCompras > tbody:last-child').empty();

    $.each(arreglo, function (index, compra) {
        var estadoVista = null;
        var botones= null;
        if (compra.finfecha == null || compra.finfecha == "0000-00-00 00:00:00") {
            
            switch (compra.estado) {
                case "iniciada":
                    botones = "<td><a href='#' onclick='cancelarCompra(4,"+compra.idcompra+","+compra.idcompraestado+")'><button class='btn btn-outline-danger'><i class='fa-solid fa-xmark me-2'></i>Cancelar</button></a></td>";
                    break;
                default:
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
        $('#tablaCompras > tbody:last-child').append('<tr><td hidden>' + compra.idcompraestado + '</td><th scope="row">' + compra.idcompra + '</th><td hidden>' + compra.usnombre + '</td><td><a href="#" class="verProductos"><button class="btn btn-outline-info col-8"><i class="fa-solid fa-list-ul mx-2"></i></button></a></td><td>' + estadoVista + '</td><td>' + compra.cofecha + '</td>' +botones+ '</tr>');
    });
}


/*################################# VER PRODUCTOS DE COMPRA #################################*/

$(document).on('click', '.verProductos', function () {

    var fila = $(this).closest('tr');
    var idcompra = fila[0].children[1].innerHTML;
    var pronombre = fila[0].children[2].innerHTML;

    $.ajax({
        type: "POST",
        url: '../Acciones/producto/listadoProds.php',
        data: { idcompra: idcompra },
        success: function (response) {
            arreglo = [];
            $.each($.parseJSON(response), function (index, productoActual) {
                
                    arreglo.push(productoActual);
                
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
    $('#usnombre').append('<i class="fa-regular fa-rectangle-list me-2"></i>Lista Productos Compra de <b><u>' + nombre + '</u></b>');

    $.each(arreglo, function (index, producto) {
        $('#listaProductos').append('<li class="list-group-item d-flex justify-content-between align-items-start"><div class="row g-0"><div class="col-md-4"><img src="./img/productos/'+producto.imagen+'"class="img-fluid rounded-start" alt="..."></div><div class="col-md-8"><div class="card-body"><h5 class="card-title">' + producto.pronombre + '</h5><p class="card-text">' + producto.prodetalle + '</p><p class="card-text"><small class="text-muted">$ ' + producto.precio + '</small></p></div></div></div><h5><span class="badge text-bg-warning rounded-pill">Cantidad: ' + producto.procantstock + '</span></h5></li>');
    });
};

//CIERRA LA LISTA
$(document).on('click', '#cerrar', function () {
    $('#usnombre').empty();
    $("#listaProductos").empty();
    document.getElementById('oculto').classList.add('d-none');
});

/*################################# CAMBIAR ESTADO COMPRA #################################*/

function cancelarCompra(idcompraestadotipo,idboton,idcompraestado) {

    bootbox.confirm({
        title: "Cancelar Compra",
        closeButton: false,
        message: "¿Est&aacute seguro de que quiere cancelar esta compra? No podr&aacute recuperar el listado de productos que hay en ella.",
        buttons: {
            cancel: {
                className: 'btn btn-outline-primary',
                label: 'Volver'
            },
            confirm: {
                className: 'btn btn-outline-danger',
                label: 'Cancelar Compra'
            }
        },
        callback: function (result) {
            if (result) {
                $.ajax({
                    type: "POST",
                    url: '../Acciones/compra/cancelarCompra.php',
                    data: { idcompraestado: idcompraestado, idcompra: idboton, idcompraestadotipo:idcompraestadotipo},
                    success: function (response) {
                        console.log(response);
                        var response = jQuery.parseJSON(response);
                        if (response) {
                            // CARTEL LIBRERIA, ESPERA 1 SEG Y LUEGO HACE EL RELOAD
                            var dialog = bootbox.dialog({
                                message: '<div class="text-center"><i class="fa fa-spin fa-spinner me-2"></i>Cancelando Compra...</div>',
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
                                message: "No se pudo cancelar la compra!",
                                size: 'small',
                                closeButton: false,
                            });
                        }
                    }
                });
            }
        }
    });

    
}