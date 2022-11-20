
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
            console.log(response);
        }
    });
   
});

function eliminar(idproducto) {

};
