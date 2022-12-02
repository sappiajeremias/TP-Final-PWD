
/*################################# FORMULARIO DE REGISTRO #################################*/
$('#registro').submit(function (e) {
    e.preventDefault();
    e.stopImmediatePropagation();

    var inputs = $('#registro :input');
    var uspass = inputs[2].value;
    var pass = hex_md5(uspass);

    arreglo = {
        usmail: inputs[1].value,
        usnombre: inputs[2].value,
        uspass: pass,
        usdeshabilitado: null,
    }

    $.ajax({
        type: "POST",
        url: './accion/registro.php',
        data: arreglo,
        success: function (response){
            console.log(response);
            var response = jQuery.parseJSON(response);
            // SI EL REGISTRO ES EXITOSO TE REDIRIGE AL FORMULARIO DE INICIO DE SESIÓN
            if (response) {
                var dialog = bootbox.dialog({
                    message: '<div class="text-center"><i class="fa fa-spin fa-spinner me-2"></i>Registrando ...</div>',
                    closeButton: false
                });
                dialog.init(function () {
                    setTimeout(function () {
                        window.location.href = "login.php";
                    }, 1000);
                });
            } else {
                bootbox.alert({
                    message: "No se pudo completar el registro!",
                    size: 'small',
                    closeButton: false,
                });
            }
        }
    });
});