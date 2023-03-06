/*################################################## CARGAR PRODUCTOS ##################################################*/
$(window).on("load", function () {
    cargarProductos();
});

function cargarProductos() {
    $.ajax({
        type: "POST",
        url: '../Acciones/producto/listarProductos.php',
        data: null,
        success: function (response) {
            var arreglo = [];
            $.each($.parseJSON(response), function (index, productoActual) {
                arreglo.push(productoActual);
            });

            armarTabla(arreglo);
        }
    });
}

// Buscamos la tabla y añadimos cada producto
function armarTabla(arreglo) {
    // VACIAMOS LA TABLA
    $('#tablaProductos > tbody').empty();
    // AGREGAMOS LOS PRODUCTOS
    $.each(arreglo, function (index, producto) {
        if (producto.deshabilitado == null || producto.deshabilitado == "0000-00-00 00:00:00") {
            var boton = '<a href="#" class="deshabilitar me-2"><button class="btn btn-outline-secondary"><i class="fa-solid fa-ban"></i></button></a>';
        } else {
            var boton = '<a href="#" class="habilitar me-2"><button class="btn btn-outline-success"><i class="fa-solid fa-square-check"></i></button></a>';
        }

        $('#tablaProductos > tbody:last-child').append('<tr><td>' + producto.idproducto + '</td><td>' + producto.pronombre + '</td><td>' + producto.prodetalle + '</td><td>' + producto.procantstock + '</td><td>' + producto.precio + '</td><td><img src="./img/productos/' + producto.imagen + '" class="rounded float-start" width="150" height="150"></td><td>' + producto.deshabilitado + '</td><td><button type="button" class="editarButton btn btn-outline-warning mx-2" data-bs-toggle="modal" data-bs-target="#editar-modal-producto"><i class="fa-solid fa-file-pen"></i></button>' + boton + '<a href="#" class="eliminar"><button class="btn btn-outline-danger"><i class="fa-solid fa-trash"></i></button></a></td></tr>');
    });
}

/*################################################## AGREGAR PRODUCTO ##################################################*/
$('#agregar').submit(function (e) {
    e.preventDefault();
    formData = new FormData(this);
    $.ajax({
        type: "POST",
        url: '../Acciones/producto/altaProd.php',
        data: formData,
        processData: false,
        contentType: false,
        success: function (response) {
            console.log(response);
            var response = jQuery.parseJSON(response);
            if (response) {
                // CARTEL LIBRERIA, ESPERA 1SEG Y REFRESCA LA TABLA
                var dialog = bootbox.dialog({
                    message: '<div class="text-center"><i class="fa fa-spin fa-spinner me-2"></i>Cargando Producto...</div>',
                    closeButton: false
                });
                dialog.init(function () {
                    setTimeout(function () {
                        $('#agregar-modal-producto').modal('hide'); //OCULTAMOS EL MODAL
                        cargarProductos();
                        bootbox.hideAll();
                    }, 1000);
                });
            } else {
                // ALERT LIBRERIA
                bootbox.alert({
                    message: "No se pudo hacer el alta!",
                    size: 'small',
                    closeButton: false,
                });
            }
        }
    });
});

/*################################################## EDITAR PRODUCTO ##################################################*/

$(document).on('click', '.editarButton', function () { //MUESTRA EL FORMULARIO Y PRECARGA LOS DATOS
    var fila = $(this).closest('tr');

    var idproducto = fila[0].children[0].innerHTML;
    var pronombre = fila[0].children[1].innerHTML;
    var prodetalle = fila[0].children[2].innerHTML;
    var procantstock = fila[0].children[3].innerHTML;
    var precio = fila[0].children[4].innerHTML;
    var prodeshabilitado = fila[0].children[6].innerHTML;

    //GUARDAMOS EL NOMBRE DEL JPG PARA REEMPLAZARLO POR UNO NUEVO, SI ES QUE SE DECIDE REEMPLAZARSE.
    var images = $(this).closest('tr').children('td').children('img').attr('src');
    url = images.replace('../img/productos/', '');
    sessionStorage.setItem('url', url);
    // EL ID PARA SABER DE QUE PRODUCTO ACTUALIZAREMOS LA IMAGEN
    sessionStorage.setItem('id', idproducto);

    var form = document.getElementById('editarForm');
    var inputs = form.getElementsByTagName('input');

    inputs[0].value = idproducto;
    inputs[1].value = prodeshabilitado;
    inputs[2].value = pronombre;
    inputs[3].value = prodetalle;
    inputs[4].value = procantstock;
    inputs[5].value = precio;
    inputs[6].value = url;
});

//ENVIA LOS DATOS
$('#editarForm').submit(function (e) {
    e.preventDefault();

    $.ajax({
        type: "POST",
        url: '../Acciones/producto/editarProd.php',
        data: $(this).serialize(),
        success: function (response) {
            var response = jQuery.parseJSON(response);
            if (response) {
                // CARTEL LIBRERIA, ESPERA 1 SEG Y REFRESCA LA TABLA
                var dialog = bootbox.dialog({
                    message: '<div class="text-center"><i class="fa fa-spin fa-spinner me-2"></i>Editando Producto...</div>',
                    closeButton: false
                });
                dialog.init(function () {
                    setTimeout(function () {
                        $('#editar-modal-producto').modal('hide'); //OCULTAMOS EL MODAL
                        cargarProductos();
                        bootbox.hideAll();
                    }, 1000);
                });
            } else {
                // ALERT LIBRERIA
                bootbox.alert({
                    message: "No se pudo completar la modificación!",
                    size: 'small',
                    closeButton: false,
                });
            }
        }
    });
});

/*################################################## EDITAR IMAGEN PRODUCTO ##################################################*/
$('.editarImagenButton').click(function () {
    url = sessionStorage.getItem('url');
    id = sessionStorage.getItem('id');
    var form = document.getElementById('editar-modal-imagen');
    var inputs = form.getElementsByTagName('input');

    inputs[0].value = url;
    inputs[1].value = id;
});

// SUBMIT FORMULARIO EDITAR IMAGEN
$('#editarImagen').submit(function (e) {
    e.preventDefault();
    formData = new FormData(this);
    $.ajax({
        type: "POST",
        url: '../Acciones/producto/editarImagen.php',
        data: formData,
        processData: false,
        contentType: false,
        success: function (response) {
            console.log(response);
            var response = jQuery.parseJSON(response);
            if (response) {
                // CARTEL LIBRERIA, ESPERA 1SEG Y REFRESCA LA TABLA
                var dialog = bootbox.dialog({
                    message: '<div class="text-center"><i class="fa fa-spin fa-spinner me-2"></i>Editando Imagen...</div>',
                    closeButton: false
                });
                dialog.init(function () {
                    setTimeout(function () {
                        $('#editar-modal-imagen').modal('hide'); //OCULTAMOS EL MODAL
                        cargarProductos();
                        bootbox.hideAll();
                    }, 1000);
                });
            } else {
                // ALERT LIBRERIA
                bootbox.alert({
                    message: "No se pudo hacer la modificación!",
                    size: 'small',
                    closeButton: false,
                });
            }
        }
    });
});

/*################################################## ELIMINAR PRODUCTO ##################################################*/

$(document).on('click', '.eliminar', function () {

    var fila = $(this).closest('tr');
    var idproducto = fila[0].children[0].innerHTML;
    var pronombre = fila[0].children[1].innerHTML;

    // CARTEL LIBRERIA
    bootbox.confirm({
        title: "Eliminar Producto?",
        closeButton: false,
        message: "Estas seguro que quieres eliminar a <b>" + pronombre + "</b> con ID: <b>" + idproducto + '</b>',
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
        url: '../Acciones/producto/eliminarProducto.php',
        data: { idproducto: idproducto },
        success: function (response) {
            var response = jQuery.parseJSON(response);
            if (response) {
                // CARTEL LIBRERIA, ESPERA 1SEG Y REFRESCA LA TABLA
                var dialog = bootbox.dialog({
                    message: '<div class="text-center"><i class="fa fa-spin fa-spinner me-2"></i>Borrando Producto...</div>',
                    closeButton: false
                });
                dialog.init(function () {
                    setTimeout(function () {
                        cargarProductos();
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
};


/*################################################## DESHABILITAR PRODUCTO ##################################################*/

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
        url: '../Acciones/producto/deshabilitarProducto.php',
        data: { idproducto: idproducto, accion: 'deshabilitar' },
        success: function (response) {
            var response = jQuery.parseJSON(response);
            if (response) {
                // CARTEL LIBRERIA, ESPERA 1SEG Y REFRESCA LA TABLA
                var dialog = bootbox.dialog({
                    message: '<div class="text-center"><i class="fa fa-spin fa-spinner me-2"></i>Deshabilitando Producto...</div>',
                    closeButton: false
                });
                dialog.init(function () {
                    setTimeout(function () {
                        cargarProductos();
                        bootbox.hideAll();
                    }, 1000);
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

/*################################################## HABILITAR PRODUCTO ##################################################*/

$(document).on('click', '.habilitar', function () {

    var fila = $(this).closest('tr');

    var idproducto = fila[0].children[0].innerHTML;
    var pronombre = fila[0].children[1].innerHTML;

    // CARTEL LIBRERIA
    bootbox.confirm({
        title: "HABILITAR PRODUCTO?",
        closeButton: false,
        message: "Estas seguro que quieres HABILITAR a <b>" + pronombre + "</b> con ID: <b>" + idproducto + '</b>',
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
        url: '../Acciones/producto/deshabilitarProducto.php',
        data: { idproducto: idproducto, accion: 'habilitar' },
        success: function (response) {
            var response = jQuery.parseJSON(response);
            if (response) {
                // CARTEL LIBRERIA, ESPERA 1SEG Y REFRESCA LA TABLA
                var dialog = bootbox.dialog({
                    message: '<div class="text-center"><i class="fa fa-spin fa-spinner me-2"></i>Habilitando Producto...</div>',
                    closeButton: false
                });
                dialog.init(function () {
                    setTimeout(function () {
                        cargarProductos();
                        bootbox.hideAll();
                    }, 1000);
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