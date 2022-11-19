$(window).on("load", function () {
    $.ajax({
        type: "POST",
        url: './accion/listarProductos.php',
        data: null,
        success: function (response) {
            var arreglo = [];
            $.each($.parseJSON(response), function (index, value) {
                $.each(value, function (index, productoActual) {
                    arreglo.push(productoActual);
                });
            });

            console.log(arreglo)

            armarTabla(arreglo);
        }
    });
});

function armarTabla(arreglo)(){
    
}