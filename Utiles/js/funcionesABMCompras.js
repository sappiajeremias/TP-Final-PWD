/*################################################## CARGAR COMPRAS ##################################################*/

$(window).on("load", function () {
    cargarCompras();
});

function cargarCompras(){
    $.ajax({
        //Llamamos a la funcion cargar compra y las cargamos en un arreglo para mandar a la funcion armarTabla
        type: "POST",
        url: '../Acciones/compras/listarCompras.php',
        data: null,
        success: function (response) {
            var arreglo = [];
            $.each($.parseJSON(response), function (index, array) {
                $.each(array, function (index, arrayCompra) {
                    arreglo.push(arrayCompra);
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
                    botones = "<td><a href='#' class='me-2' onclick='cambiarEstado(2,"+compra.idcompra+","+compra.idcompraestado+")'><button class='btn btn-outline-success'><i class='fa-solid fa-check me-2'></i>Aceptar</button></a><a href='#' onclick='cambiarEstado(4,"+compra.idcompra+","+compra.idcompraestado+")'><button class='btn btn-outline-danger'><i class='fa-solid fa-xmark me-2'></i>Cancelar</button></a></td>";
                    break;
                case "aceptada":
                    botones = "<td><a href='#' class='me-2' onclick='cambiarEstado(3,"+compra.idcompra+","+compra.idcompraestado+")'><button class='btn btn-outline-info'><i class='fa-solid fa-truck-fast me-2'></i>Enviar</button></a><a href='#' onclick='cambiarEstado(4,"+compra.idcompra+","+compra.idcompraestado+")'><button class='btn btn-outline-danger'><i class='fa-solid fa-xmark me-2'></i>Cancelar</button></a></td>";
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
        $('#tablaCompras > tbody:last-child').append('<tr><td hidden>' + compra.idcompraestado + '</td><th scope="row">' + compra.idcompra + '</th><td>' + compra.usnombre + '</td><td><a href="#" class="verProductos"><button class="btn btn-outline-info col-8"><i class="fa-solid fa-list-ul mx-2"></i></button></a></td><td>' + estadoVista + '</td><td>' + compra.cofecha + '</td>' + botones + '</tr>');
    });
}

/*################################################## VER PRODUCTOS DE COMPRA ##################################################*/

$(document).on('click', '.verProductos', function () {

    var fila = $(this).closest('tr');
    var idcompra = fila[0].children[1].innerHTML;
    var pronombre = fila[0].children[2].innerHTML;


    $.ajax({
        type: "POST",
        url: '../Acciones/compras/listarProdCompra.php',
        data: { idcompra: idcompra },
        success: function (response) {
            console.log(response);
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
                }, 750);
            });
        }
    });

});

function listaProductos(arreglo, nombre) {
    document.getElementById('oculto').classList.remove('d-none');
    $('#usnombre').append('<i class="fa-regular fa-rectangle-list me-2"></i>Lista Productos Compra de <b><u>' + nombre + '</u></b>');
    $.each(arreglo, function (index, producto) {
        $('#listaProductos').append('<div class="card mb-3"><div class="row g-0"><div class="col-md-4"><img src="./img/productos/'+producto.imagen+'" width="350" class="img-fluid rounded-start" ></div><div class="col-md-8"><div class="card-body"><h5 class="card-title">' + producto.pronombre + '</h5><p class="card-text">' + producto.prodetalle + '</p><p class="card-text"><small class="text-muted">$ ' + producto.precio + '</small></p><h5><span class="badge text-bg-warning rounded-pill">Cantidad: ' + producto.procantstock + '</span></h5></div></div></div></div>');
    });
};

//CIERRA LA LISTA
$(document).on("click", "#cerrar", function () {
  $("#usnombre").empty();
  $("#listaProductos").empty();
  document.getElementById("oculto").classList.add("d-none");
});

/*################################################## CAMBIAR ESTADO COMPRA ##################################################*/

function cambiarEstado(idcompraestadotipo,idcompra,idcompraestado) {  
    $.ajax({
        type: "POST",
        url: '../Acciones/compras/modificarEstadoCompra.php',
        data: { idcompraestado: idcompraestado, idcompra: idcompra, idcompraestadotipo: idcompraestadotipo },
        success: function (response) {
            console.log(response);
            var response = jQuery.parseJSON(response);
            if (response) {
                // CARTEL LIBRERIA, ESPERA 1 SEG Y LUEGO HACE EL RELOAD
                var dialog = bootbox.dialog({
                    message: '<div class="text-center"><i class="fa fa-spin fa-spinner me-2"></i>Modificando Estado Compra...</div>',
                    closeButton: false
                });
                dialog.init(function () {
                    setTimeout(function () {
                        cargarCompras();
                        bootbox.hideAll();
                    }, 750);
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