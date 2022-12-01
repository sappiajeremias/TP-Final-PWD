/*################################# CARGAR PRODUCTO #################################*/
$(window).on("load", function () {
    cargarProductos();
});

function cargarProductos(){
    $.ajax({
        type: "POST",
        url: './accion/producto/listarProductos.php',
        data: null,
        success: function (response) {
            var arreglo = [];
            $.each($.parseJSON(response), function (index, value) {
                $.each(value, function (index, productoActual) {
                    arreglo.push(productoActual);
                });
            });

            armarTabla(arreglo);
        }
    });
}

// Buscamos la tabla y añadimos cada producto
function armarTabla(arreglo) {
    // VACIAMOS LA TABLA
    $('#tablaProductos > tbody').empty();
    // GENERAMOS EL FORM PARA AGREGAR EL PRODUCTO
    $('#tablaProductos > tbody').append('<tr class="table-active"><td><input class="form-control" type="number" placeholder="#" readonly></td><td><input class="form-control" type="text" placeholder="Nombre"></td><td><input class="form-control" type="text" placeholder="Detalle"></td><td><input class="form-control" type="number" min=0 placeholder="Stock"></td><td><input class="form-control" type="number" min=0 placeholder="Precio"></td><td><input class="form-control" type="text" placeholder="Imagen"></td><td><input class="form-control" type="text" placeholder="null" readonly></td><td colspan="2"><a href="#" class="agregar"><button class="btn btn-outline-success"><i class="fa-solid fa-folder-plus"></i></button></a></td></tr>');
    // AGREGAMOS LOS PRODUCTOS
    $.each(arreglo, function (index, producto) {
        if (producto.deshabilitado == null || producto.deshabilitado == "0000-00-00 00:00:00"){
            var boton = '<a href="#" class="deshabilitar me-2"><button class="btn btn-outline-secondary"><i class="fa-solid fa-ban"></i></button></a>';
        } else {
            var boton = '<a href="#" class="habilitar me-2"><button class="btn btn-outline-success"><i class="fa-solid fa-square-check"></i></button></a>';

        }


        $('#tablaProductos > tbody:last-child').append('<tr><td>' + producto.idproducto + '</td><td>' + producto.pronombre + '</td><td>' + producto.prodetalle + '</td><td>' + producto.procantstock + '</td><td>' + producto.precio + '</td><td hidden>'+producto.imagen+'</td><td><img src="../img/'+producto.imagen+'" class="rounded float-start" width="150" height="150"></td><td>' + producto.deshabilitado + '</td><td><a href="#" class="editar me-2"><button class="btn btn-outline-warning"><i class="fa-solid fa-file-pen"></i></button></a>'+boton+'<a href="#" class="eliminar"><button class="btn btn-outline-danger"><i class="fa-solid fa-trash"></i></button></a></td></tr>');
    });
}

/*################################# AGREGAR PRODUCTO #################################*/
$(document).on('click', '.agregar', function () {
    var row = $(this).closest('tr').find("input");

    var nombre = row[1].value;
    var detalle = row[2].value;
    var stock = row[3].value;
    var precio = row[4].value;
    var imagen = row[5].value;

    arreglo = {
        'pronombre': nombre,
        'prodetalle': detalle,
        'procantstock': stock,
        'precio': precio,
        'prodeshabilitado': null,
        'imagen': imagen
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
        url: './accion/producto/altaProd.php',
        data: array,
        success: function (response) {
            console.log(response);
            var response = jQuery.parseJSON(response);
            if (response.respuesta) {
                // CARTEL LIBRERIA, ESPERA 1,5 SEG Y LUEGO HACE EL RELOAD
                var dialog = bootbox.dialog({
                    message: '<div class="text-center"><i class="fa fa-spin fa-spinner me-2"></i>Cargando Producto...</div>',
                    closeButton: false
                });
                dialog.init(function () {
                    setTimeout(function () {
                        cargarProductos();
                        bootbox.hideAll();
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
    var imagen = fila[0].children[5].innerHTML;
    var prodeshabilitado = fila[0].children[7].innerHTML;

    var form = document.getElementById('editarP');

    var inputs = form.getElementsByTagName('input');

    document.getElementById('idproducto').innerHTML = idproducto;

    inputs[0].value = idproducto;
    inputs[1].value = pronombre;
    inputs[2].value = prodetalle;
    inputs[3].value = procantstock;
    inputs[4].value = precio;
    inputs[5].value = prodeshabilitado;
    inputs[6].value = imagen;
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
            url: './accion/producto/editarProd.php',
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
                            document.getElementById('editarProducto').classList.add('d-none');
                            cargarProductos();
                            bootbox.hideAll();
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
        url: './accion/producto/eliminarProducto.php',
        data: { idproducto: idproducto },
        success: function (response) {
            var response = jQuery.parseJSON(response);
            console.log(response.respuesta);
            if (response.respuesta) {
                // CARTEL LIBRERIA, ESPERA 1,5 SEG Y LUEGO HACE EL RELOAD
                var dialog = bootbox.dialog({
                    message: '<div class="text-center"><i class="fa fa-spin fa-spinner me-2"></i>Borrando Producto...</div>',
                    closeButton: false
                });
                dialog.init(function () {
                    setTimeout(function () {
                        cargarProductos();
                        bootbox.hideAll();
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


/*################################# DESHABILITAR PRODUCTO #################################*/

$(document).on('click', '.deshabilitar', function () {

    var fila = $(this).closest('tr');
    
    var idproducto = fila[0].children[0].innerHTML;
    var pronombre = fila[0].children[1].innerHTML;
    
    // CARTEL LIBRERIA
    bootbox.confirm({
        closeButton: false,
        title: "DESHABILITAR PRODUCTO?",
        message: "Estas seguro que quieres DESHABILITAR a <b>" + pronombre + "</b> con ID:<b>" + idproducto + "</b>",
        buttons: {
            cancel: {
                className: 'btn btn-outline-danger',
                label: '<i class="fa fa-times"></i> Cancelar'
            },
            confirm: {
                className: 'btn btn-outline-secondary',
                label: '<i class="fa-solid fa-ban"></i> Deshabilitar'
            }
        },
        callback: function (result) {
            if (result) {
                deshabilitar(idproducto);
            }
        }
    });
});

function deshabilitar(idproducto) {
    $.ajax({
        type: "POST",
        url: './accion/producto/deshabilitarProducto.php',
        data: { idproducto: idproducto, accion: 'deshabilitar'},
        success: function (response) {
            console.log(response)
            var response = jQuery.parseJSON(response);
            console.log(response.respuesta);
            if (response.respuesta) {
                // CARTEL LIBRERIA, ESPERA 1,5 SEG Y LUEGO HACE EL RELOAD
                var dialog = bootbox.dialog({
                    message: '<div class="text-center"><i class="fa fa-spin fa-spinner me-2"></i>Deshabilitando Producto...</div>',
                    closeButton: false
                });
                dialog.init(function () {
                    setTimeout(function () {
                        cargarProductos();
                        bootbox.hideAll();
                    }, 1500);
                });
            } else {
                // ALERT LIBRERIA
                bootbox.alert({
                    message: "No se pudo deshabilitar el producto!",
                    size: 'small',
                    closeButton: false,
                });
            }
        }
    });
};

/*################################# HABILITAR PRODUCTO #################################*/

$(document).on('click', '.habilitar', function () {

    var fila = $(this).closest('tr');
    
    var idproducto = fila[0].children[0].innerHTML;
    var pronombre = fila[0].children[1].innerHTML;

    // CARTEL LIBRERIA
    bootbox.confirm({
        title: "HABILITAR PRODUCTO?",
        closeButton: false,
        message: "Estas seguro que quieres HABILITAR a <b>" + pronombre + "</b> con ID: <b>" + idproducto+'</b>',
        buttons: {
            cancel: {
                className: 'btn btn-outline-danger',
                label: '<i class="fa fa-times"></i> Cancelar'
            },
            confirm: {
                className: 'btn btn-outline-success',
                label: '<i class="fa-solid fa-square-check"></i> Habilitar'
            }
        },
        callback: function (result) {
            if (result) {
                habilitar(idproducto);
            }
        }
    });
});

function habilitar(idproducto) {

    $.ajax({
        type: "POST",
        url: './accion/producto/deshabilitarProducto.php',
        data: {idproducto: idproducto, accion: 'habilitar'},
        success: function (response) {
            console.log(response);
            var response = jQuery.parseJSON(response);
            console.log(response.respuesta);
            if (response.respuesta) {
                // CARTEL LIBRERIA, ESPERA 1,5 SEG Y LUEGO HACE EL RELOAD
                var dialog = bootbox.dialog({
                    message: '<div class="text-center"><i class="fa fa-spin fa-spinner me-2"></i>Habilitando Producto...</div>',
                    closeButton: false
                });
                dialog.init(function () {
                    setTimeout(function () {
                        cargarProductos();
                        bootbox.hideAll();
                    }, 1500);
                });
            } else {
                // ALERT LIBRERIA
                bootbox.alert({
                    message: "No se pudo habilitar el producto!",
                    size: 'small',
                    closeButton: false,
                });
            }
        }
    });
};