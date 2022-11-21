/*################################# CARGAR PRODUCTO #################################*/
// Mientras carga el sitio consulta al accion listarProd
$(window).on("load", function () {
    $.ajax({
        type: "POST",
        url: './accion/listarProductos.php',
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
    $.each(arreglo, function (index, producto) {
        $('#tablaProductos > tbody:last-child').append('<tr><td>' + producto.idproducto + '</td><td>' + producto.pronombre + '</td><td>' + producto.prodetalle + '</td><td>' + producto.procantstock + '</td><td>' + producto.precio + '</td><td><a href="#" class="editar"><button class="btn btn-outline-warning"><i class="fa-solid fa-file-pen mx-2"></i></button></a></td><td><a href="#" class="eliminar"><button class="btn btn-outline-danger"><i class="fa-solid fa-trash mx-2"></i></button></a></td></tr>');
    });
}

/*################################# AGREGAR PRODUCTO #################################*/
$(document).on('click', '.agregar', function () {
    var row = $(this).closest('tr').find("input");

    var nombre = row[1].value;
    var detalle = row[2].value;
    var stock = row[3].value;
    var precio = row[4].value;

    arreglo = {
        'pronombre': nombre,
        'prodetalle': detalle,
        'procantstock': stock,
        'precio': precio
    };

    var verificador = true;

    $.each(arreglo, function (index, value) {
        console.log(value)
        if (value === '') {
            verificador = false;
        }
    });

    if (verificador) {
        agregar(arreglo);
    } else {
        // ALERT LIBRERIA
        bootbox.alert({
            message: "No puedes dejar campos vacios!",
            size: 'small',
            closeButton: false,
        });
    }

});

function agregar(array) {
    $.ajax({
        type: "POST",
        url: './accion/altaProd.php',
        data: array,
        success: function (response) {
            var response = jQuery.parseJSON(response);
            if (response.respuesta) {
                // CARTEL LIBRERIA, ESPERA 1,5 SEG Y LUEGO HACE EL RELOAD
                var dialog = bootbox.dialog({
                    message: '<div class="text-center"><i class="fa fa-spin fa-spinner me-2"></i>Cargando Producto...</div>',
                    closeButton: false
                });
                dialog.init(function () {
                    setTimeout(function () {
                        location.reload();
                    }, 1500);
                });
            } else {
                bootbox.alert({
                    message: "Respuesta: " + response.respuesta,
                    size: 'small',
                    closeButton: false,
                });
            }
        }
    });
}


/*################################# EDITAR PRODUCTO #################################*/

$(document).on('click', '.editar', function () { //MUESTRA EL FORMULARIO Y PRECARGA LOS DATOS
    document.getElementById('editarProducto').classList.remove('d-none');
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

/*################################# ELIMINAR PRODUCTO #################################*/

$(document).on('click', '.eliminar', function () {

    var fila = $(this).closest('tr');
    var idproducto = fila[0].children[0].innerHTML;
    var pronombre = fila[0].children[1].innerHTML;

    // CARTEL LIBRERIA
    bootbox.confirm({
        title: "Eliminar Producto?",
        closeButton: false,
        message: "Estas seguro que quieres eliminar a <b>" + pronombre + "</b> con ID: <b>" + idproducto+'</b>',
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
                eliminar(idproducto);
            }
        }
    });
});

function eliminar(idproducto) {

    $.ajax({
        type: "POST",
        url: './accion/eliminarProducto.php',
        data: { idproducto: idproducto },
        success: function (response) {
            var response = jQuery.parseJSON(response);
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
                console.log(response.respuesta);
            }
        }
    });
};
