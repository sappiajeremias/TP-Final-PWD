$(document).on('click', '.agregar', function () {
    var row = $(this).closest('tr').find("input");

    var nombre = row[1].value;
    var detalle = row[2].value;
    var stock = row[3].value;

    arreglo = {
        'pronombre': nombre,
        'prodetalle': detalle,
        'procantstock': stock
    };

    var verificador = true;

    $.each(arreglo, function (index, value) {
        if (value === ''){
           verificador = false;
        }
    });

    if (verificador){
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

function agregar(array){
    $.ajax({
        type: "POST",
        url: './accion/altaProd.php',
        data: array,
        success: function (response) {
            var response = jQuery.parseJSON(response);
            if(response.respuesta){
                location.reload();
            } else {
                bootbox.alert({
                    message: "Respuesta: "+response.respuesta,
                    size: 'small',
                    closeButton: false,
                });
            }
        }
    });
}
