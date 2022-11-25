/*################################# CARGAR PRODUCTO #################################*/
// Mientras carga el sitio consulta al accion listarCarrito
/*
$(window).on("load", function () {
    $.ajax({
        type: "POST",
        url: './accion/listarProdCarrito.php',
        data: null,
        success: function (response) {
            console.log(response)
            var arreglo = [];
            $.each($.parseJSON(response), function (index, value) {
                $.each(value, function (index, productoActual) {
                    console.log(productoActual)
                    arreglo.push(productoActual);
                });
            });

            armarTabla(arreglo);
        }
    });
});

// Buscamos la tabla y añadimos cada producto
function armarTabla(arreglo) {
    $.each(arreglo, function (index, compraItem) {
        $('#tablaCarrito > tbody').append('<tr><td>' + compraItem.pronombre + '</td><td>' + compraItem.precio + '</td><td><a><button><i class="fa-solid fa-minus"></i></button></a><input '+ compraItem.cantidad + '</td><td>' + compraItem.subtotal + '</td><td><a href="#" class="eliminar"><button class="btn btn-outline-danger"><i class="fa-solid fa-trash mx-2"></i></button></a></td></tr>');
    });
}
*/
/*################################# AGREGAR PRODUCTO AL CARRITO #################################*/
function agregarACarrito(idproducto) {

    console.log(idproducto)

    arreglo = {
        'idproducto': idproducto,
        'cicantidad': 1
    };

    var verificador = true;

    $.each(arreglo, function (index, value) {
        if (value === '') {
            verificador = false;
        }
    });

    if (verificador) {
        agregar(arreglo);
    } else {
        // ALERT LIBRERIA
        bootbox.alert({
            message: "No se puede poner en el carrito",
            size: 'small',
            closeButton: false,
        });
    }

}


function agregar(array) {
    $.ajax({
        type: "POST",
        url: '../Cliente/accion/agregarProdCarrito.php',
        data: array,
        success: function (response) {
            console.log(response)
            var response = jQuery.parseJSON(response);
            if (response.respuesta) {
                // CARTEL LIBRERIA, ESPERA 1,5 SEG Y LUEGO HACE EL RELOAD
                var dialog = bootbox.dialog({
                    message: '<div class="text-center"><i class="fa fa-spin fa-spinner me-2"></i>Agregando producto al carrito...</div>',
                    closeButton: false
                });
                dialog.init(function () {
                    setTimeout(function () {
                        location.reload();
                    }, 1500);
                });
            } else {
                bootbox.alert({
                    message: response.errorMsg,
                    size: 'small',
                    closeButton: false,
                });
            }
        }
    });
}


/*################################# EDITAR PRODUCTO #################################*/
/*
$(document).on('click', '.carrito', function () { //MUESTRA EL FORMULARIO Y PRECARGA LOS DATOS
    document.getElementById('pagarProducto').classList.remove('d-none');
    var fila = $(this).closest('tr');
    var idproducto = fila[0].children[0].innerHTML;
    var pronombre = fila[0].children[1].innerHTML;
    var prodetalle = fila[0].children[2].innerHTML;
    var procantstock = fila[0].children[3].innerHTML;
    var precio = fila[0].children[4].innerHTML;

    var form = document.getElementById('editarP');

    var inputs = form.getElementsByTagName('input');

    document.getElementById('idproducto').innerHTML = idproducto;

    inputs[0].value = idproducto;
    inputs[1].value = pronombre;
    inputs[2].value = prodetalle;
    inputs[3].value = procantstock;
    inputs[4].value = precio;
});

//CIERRA EL FORMULARIO
$(document).on('click', '#cancelar', function () {
    document.getElementById('editarProducto').classList.add('d-none');
});


//ENVIA LOS DATOS
$(document).ready(function () {
    $('form').submit(function (e) {
        e.preventDefault();

        $.ajax({
            type: "POST",
            url: './accion/editarProd.php',
            data: $(this).serialize(),
            success: function (response) {
                var response = jQuery.parseJSON(response);
                if (response.respuesta) {
                    // CARTEL LIBRERIA, ESPERA 1,5 SEG Y LUEGO HACE EL RELOAD
                    var dialog = bootbox.dialog({
                        message: '<div class="text-center"><i class="fa fa-spin fa-spinner me-2"></i>Editando Producto...</div>',
                        closeButton: false
                    });
                    dialog.init(function () {
                        setTimeout(function () {
                            location.reload();
                        }, 1500);
                    });
                } else {
                    console.log(response.respuesta);
                }
            }
        });
    });
});
*/
/*################################# ELIMINAR PRODUCTO DEL CARRITO #################################*/

$(document).on('click', '.eliminar', function () {

    var fila = $(this).closest('tr');
    var idcompraitem = fila[0].children[0].innerHTML;
    var pronombre = fila[0].children[1].innerHTML;

    // CARTEL LIBRERIA
    bootbox.confirm({
        title: "Eliminar Producto",
        closeButton: false,
        message: "¿Est&aacutes seguro que quieres eliminar el producto <b>" + pronombre + "</b> del carrito?",
        buttons: {
            cancel: {
                className: 'btn btn-outline-danger',
                label: '<i class="fa fa-times"></i> Cancelar'
            },
            confirm: {
                className: 'btn btn-outline-success',
                label: '<i class="fa fa-check"></i> Confirmar'
            }
        },
        callback: function (result) {
            if (result) {
                eliminar(idcompraitem);
            }
        }
    });
});

function eliminar(idcompraitem, cantidad) {//cantidad

    $.ajax({
        type: "POST",
        url: './accion/eliminarProdCarrito.php',
        data: { idcompraitem: idcompraitem,
                cicantidad:cantidad },

        success: function (response) {
            var response = jQuery.parseJSON(response)
            console.log(response.respuesta)
            if (response.respuesta) {
                // CARTEL LIBRERIA, ESPERA 1,5 SEG Y LUEGO HACE EL RELOAD
                var dialog = bootbox.dialog({
                    message: '<div class="text-center"><i class="fa fa-spin fa-spinner me-2"></i>Borrando Producto...</div>',
                    closeButton: false
                });
                dialog.init(function () {
                    setTimeout(function () {
                        location.reload();
                    }, 1500);
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
};

$(document).on('click', '.pagar', function () {

    var fila = $(this).closest('tr');
    var valorCompra = fila[0].children[1].innerHTML;

    // CARTEL LIBRERIA
    bootbox.confirm({
        title: "Pagar productos",
        closeButton: false,
        message: "¿Quiere finalizar su compra?",
        buttons: {
            cancel: {
                className: 'btn btn-outline-danger',
                label: '<i class="fa fa-times"></i> Cancelar'
            },
            confirm: {
                className: 'btn btn-outline-success',
                label: '<i class="fa fa-check"></i> Confirmar'
            }
        },
        callback: function (result) {
            if (result) {
                comprar(valorCompra);
            }
        }
    });
});

function comprar(valorcompra) {//cantidad

    $.ajax({
        type: "POST",
        url: './accion/ejecutarCompraCarrito.php',
        data: { valorcompra: valorcompra },

        success: function (response) {
            var response = jQuery.parseJSON(response)
            console.log(response.respuesta)
            if (response.respuesta) {
                // CARTEL LIBRERIA, ESPERA 1,5 SEG Y LUEGO HACE EL RELOAD
                var dialog = bootbox.dialog({
                    message: '<div class="text-center"><i class="fa fa-spin fa-spinner me-2"></i>Borrando Producto...</div>',
                    closeButton: false
                });
                dialog.init(function () {
                    setTimeout(function () {
                        location.reload();
                    }, 1500);
                });
            } else {
                // ALERT LIBRERIA
                bootbox.alert({
                    message: "No se puede realizar la compra!",
                    size: 'small',
                    closeButton: false,
                });
            }
        }
    });
};

