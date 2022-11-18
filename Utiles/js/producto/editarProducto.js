$(document).on('click', '.editar', function () { //MUESTRA EL FORMULARIO Y PRECARGA LOS DATOS

    document.getElementById('editarProducto').classList.remove('d-none');

    var fila = $(this).closest('tr');

    var idproducto = fila[0].children[0].innerHTML;
    var pronombre = fila[0].children[1].innerHTML;
    var prodetalle = fila[0].children[2].innerHTML;
    var procantstock = fila[0].children[3].innerHTML;

    var form = document.getElementById('editarP');
    
    var inputs = form.getElementsByTagName('input');

    document.getElementById('idproducto').innerHTML = idproducto;

    inputs[0].value = idproducto;
    inputs[1].value = pronombre;
    inputs[2].value = prodetalle;
    inputs[3].value = procantstock;
});

//CIERRA EL FORMULARIO
$(document).on('click', '#cancelar', function () {
    document.getElementById('editarProducto').classList.add('d-none');
});

//ENVIA LOS DATOS
$(document).ready(function () {
    $('form').submit(function (e) {
        e.preventDefault();
        console.log($(this).serialize());
        datosForm = $(this).serialize();

        /*$.post("./accion/editarProd.php",{ data: $(this).serialize() },
            function(response) {
            }
        );
        $.post("./accion/editarProd.php", { data: datosForm},
            function (response) {
                var response = jQuery.parseJSON(response);
                console.log(response.respuesta);
            }
        );*/
        
        $.ajax({
            type: "POST",
            url: './accion/editarProd.php',
            data: $(this).serialize(),
            success: function (response) {
                var response = jQuery.parseJSON(response);
                if(response.respuesta){
                    location.reload();
                } else {
                    console.log(response.respuesta);
                }
            }
        });
    });
});


