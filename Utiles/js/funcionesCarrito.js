
//################################### LISTAR PRODUCTOS CARRITO ################################

$(window).on("load", function () {
    cargarProductosCarrito();
});

function cargarProductosCarrito(){
    $.ajax({
        type: "POST",
        url: './accion/listadoProdCarrito.php',
        data: null,
        success: function (response) {
            console.log(response);
            var arreglo = [];
            $.each($.parseJSON(response), function (index, value) {
                $.each(value, function (index, compraItemActual) {
                    arreglo.push(compraItemActual);
                });
            });

            armarTablaCarrito(arreglo);
        }
    });
}

// Buscamos la tabla y añadimos cada compra
function armarTablaCarrito(arreglo) {

    $('#tablaCarrito > tbody:last-child').empty();
    //console.log(arreglo.length);
    
    if((arreglo.length)>0){ 
        var idcompra=arreglo[0].idcompra;
        //console.log(idcompra);
        
    $('#estructuraCarrito table:last-child').append('<caption>Carrito de compras</caption><thead class=""><tr><th hidden >'+idcompra+'</th><th>Producto</th><th>Precio</th><th>Cantidad</th><th>Subtotal</th><th><a href="#" class="vaciarCarrito"><button class="btn btn-outline-danger">Vaciar Carrito</button></a></th></tr></thead><tbody class="table-group-divider"></tbody>');
    
    var total=0;
    $.each(arreglo, function (index, compraItem) {

    total=total+compraItem.subtotal;

    $('#tablaCarrito > tbody:last-child').append('<tr><td hidden>' + compraItem.idcompraitem + '</td><td hidden>' + compraItem.idproducto + '</td><td hidden>' + compraItem.idcompra + '</td><td><img src="../img/>' + compraItem.imagen + '" class="rounded float-start" width="150" height="150"><p>'+ compraItem.pronombre + '</p><p>' + compraItem.detalle + '</p></td><td><p><strong> $ ' + compraItem.precio + ' ARS </strong></p></td><td><input min=1 max='+compraItem.procantstock+' type="number" class="form-control" id="procantstock" name="procantstock" autocomplete="off" value='+compraItem.cicantidad+'></td><td><p class="text-danger"><strong> $ ' +compraItem.subtotal +' ARS </strong></p></td><td><a href="#" class="eliminar"><button class="btn btn-outline-danger"><i class="fa-solid fa-trash mx-2"></i></button></a></td></tr>');
    });
    
    $('#totalPagar').append('Total a pagar: '+total+'<hr><a class="pagar" href="#"><button class="btn btn-outline-successcol-11">Pagar</button></a>')
}else{
    $('#estructuraCarrito > table:last-child').append('<div class="card mb-3" style="max-width: 540px;"><div class="row g-0"><div class="col-md-4"><img src="../img/plantaTriste.PNG" class="img-fluid rounded-start" alt="..."></div><div class="col-md-8"><div class="card-body"><h5 class="card-title">Carrito de compras vac&iacuteo</h5><p class="card-text">A&uacuten no has agregado productos al carrito. Ingresa al cat&aacutelogo de productos para seleccionar los que mas te gusten.</p><p class="card-text"><a href="../Home/productos.php"><button class="btn btn-outline-success col-11">Cat&aacutelogo de productos</button></a></p></div></div></div></div>');
}

}
/*################################ EDITAR CANTIDAD COMPRA ITEM ##############################*/

$(document).on('change', '#procantstock', function () {

    var fila = $(this).closest('tr');
    var idcompraitem = fila[0].children[0].innerHTML;
    var idproducto = fila[0].children[1].innerHTML;
    var idcompra = fila[0].children[2].innerHTML;
    var cantpro = fila[0].children[5].value();

    console.log(idcompraitem)
    console.log(idproducto)
    console.log(idcompra)
    console.log(cantpro)

    arreglo = {
        'idcompraitem': idcompraitem,
        'idproducto': idproducto,
        'idcompra': idcompra,
        'cicantidad': cantpro
    };
    
    var verificador = true;

    $.each(arreglo, function (index, value) {
        if (value === '') {
            verificador = false;
        }
    });

    if (verificador) {
        editarCantPro(arreglo);
    } else {
        // ALERT LIBRERIA
        bootbox.alert({
            message: "No se puede editar la cantidad ",
            size: 'small',
            closeButton: false,
        });
    }
    editarCantPro(arreglo);
      
});

function editarCantPro(array) {//cantidad

    $.ajax({
        type: "POST",
        url: './accion/editarCantProducto.php',
        data: array,

        success: function (response) {
            var response = jQuery.parseJSON(response)
            console.log(response.respuesta)
            if (response.respuesta) {
                // CARTEL LIBRERIA, ESPERA 1,5 SEG Y LUEGO HACE EL RELOAD
                dialog.init(function () {
                    setTimeout(function () {
                        cargarProductosCarrito();
                    }, 1000);
                });
            } else {
                // ALERT LIBRERIA
                bootbox.alert({
                    message: "No se pudo editar la cantidad del producto!",
                    size: 'small',
                    closeButton: false,
                });
            }
        }
    });
};



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


/*################################# ELIMINAR PRODUCTO DEL CARRITO #################################*/

$(document).on('click', '.eliminar', function () {

    var fila = $(this).closest('tr');
    var idcompraitem = fila[0].children[0].innerHTML;
    var pronombre = fila[0].children[3].innerHTML;

    // CARTEL LIBRERIA
    bootbox.confirm({
        title: "Eliminar Producto",
        closeButton: false,
        message: pronombre,
        buttons: {
            cancel: {
                className: 'btn btn-outline-primary',
                label: 'Cancelar'
            },
            confirm: {
                className: 'btn btn-outline-danger',
                label: 'Eliminar'
            }
        },
        callback: function (result) {
            if (result) {
                eliminar(idcompraitem);
            }
        }
    });
});

function eliminar(idcompraitem) {//cantidad

    $.ajax({
        type: "POST",
        url: './accion/eliminarProdCarrito.php',
        data: { idcompraitem: idcompraitem},

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

$(document).on('click', '.vaciarCarrito', function () {

    var fila = $(this).closest('tr');
    var idcompra = fila[0].children[0].innerHTML;

    // CARTEL LIBRERIA
    bootbox.confirm({
        title: "¿Desea vaciar el carrito?",
        closeButton: false,
        message: "Perder&aacute todos los productos que eligi&oacute.",
        buttons: {
            cancel: {
                className: 'btn btn-outline-primary',
                label: 'Cancelar'
            },
            confirm: {
                className: 'btn btn-outline-danger',
                label: 'Eliminar'
            }
        },
        callback: function (result) {
            if (result) {
                vaciarCarrito(idcompra);
            }
        }
    });
});

function vaciarCarrito(idcompra) {

    $.ajax({
        type: "POST",
        url: './accion/vaciarCarrito.php',
        data: { idcompra: idcompra},

        success: function (response) {
            var response = jQuery.parseJSON(response)
            console.log(response.respuesta)
            if (response.respuesta) {
                // CARTEL LIBRERIA, ESPERA 1,5 SEG Y LUEGO HACE EL RELOAD
                var dialog = bootbox.dialog({
                    message: '<div class="text-center"><i class="fa fa-spin fa-spinner me-2"></i>Vaciando carrito...</div>',
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
                    message: "No se pudo eliminar el carrito",
                    size: 'small',
                    closeButton: false,
                });
            }
        }
    });
};

//################################## COMPRAR PRODUCTOS CARRITO ################################

$(document).on('click', '.pagar', function () {

    var fila = $(this).text();
    
    console.log(fila);

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
                comprar();
            }
        }
    });
});

function comprar() {//cantidad

    $.ajax({
        type: "POST",
        url: './accion/ejecutarCompraCarrito.php',
        data: null,

        success: function (response) {
            var response = jQuery.parseJSON(response)
            console.log(response.respuesta)
            if (response.respuesta) {
                // CARTEL LIBRERIA, ESPERA 1,5 SEG Y LUEGO HACE EL RELOAD
                var dialogoRedireccion = bootbox.dialog({
                    message: '<div class="text-center"><i class="fa fa-spin fa-spinner me-2"></i>Gracias por su compra!</div>',
                    closeButton: false
                });
                dialogoRedireccion.init(function () {
                    setTimeout(function () {
                        location.href='../Home/index.php';
                    }, 3000);
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

