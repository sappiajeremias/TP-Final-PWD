/*################################# FORMULARIO DE INICIO SESIÓN #################################*/
$('#login').submit(function (e) {
    
    e.preventDefault();
    e.stopImmediatePropagation();

    var inputs = $('#login :input');
    var uspass = inputs[2].value;
    var pass = hex_md5(uspass);

    arreglo = {
        usnombre: inputs[1].value,
        uspass: pass,
    }

    $.ajax({
        type: "POST",
        url: './accion/ingresar.php',
        data: arreglo,
        success: function (response) {
            console.log(response);
            var response = jQuery.parseJSON(response);
            // SI SE PUDO INICAR SESIÓN O NO, REDIRIGIMOS HACIA INDEX CON UN MENSAJE
            if (response) {
                var dialog = bootbox.dialog({
                    message: '<div class="text-center"><i class="fa fa-spin fa-spinner me-2"></i>Iniciando...</div>',
                    closeButton: false
                });
                dialog.init(function () {
                    setTimeout(function () {
                        window.location.href = "../Home/index.php?mensaje=Sesión iniciada correctamente!";
                    }, 750);
                });
            } else {
                bootbox.alert({
                    message: "No se pudo iniciar Sesión",
                    size: 'small',
                    closeButton: false,
                });
            }
        }
    });
});