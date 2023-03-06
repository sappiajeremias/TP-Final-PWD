/*################################# FORMULARIO DE INICIO SESIÓN #################################*/
$("#login").submit(function (e) {
  var inputs = $("#login :input");

  if (inputs[1].value != "" || inputs[2].value != "") {
    var uspass = inputs[2].value;
    var pass = hex_md5(uspass);

    arreglo = {
      usnombre: inputs[1].value,
      uspass: pass,
    };

    e.preventDefault();
    e.stopImmediatePropagation();

    $.ajax({
      type: "POST",
      url: "../Acciones/login/ingresar.php",
      data: arreglo,
      success: function (response) {
        console.log(response);
        var response = jQuery.parseJSON(response);
        // SI SE PUDO INICAR SESIÓN O NO, REDIRIGIMOS HACIA INDEX CON UN MENSAJE
        if (response) {
          var dialog = bootbox.dialog({
            message:
              '<div class="text-center"><i class="fa fa-spin fa-spinner me-2"></i>Iniciando...</div>',
            closeButton: false,
          });
          dialog.init(function () {
            setTimeout(function () {
              window.location.href = "./index.php?mensaje=Sesión iniciada correctamente!";
            }, 750);
          });
        } else {
          bootbox.alert({
            message: "No se pudo iniciar sesión, verifique los datos ingresados.",
            size: "small",
            closeButton: false,
          });
        }
      },
    });
    
  } else {
    bootbox.alert({
      message: "Debe completar todos los campos.",
      size: "small",
      closeButton: false,
    });
  }
});

