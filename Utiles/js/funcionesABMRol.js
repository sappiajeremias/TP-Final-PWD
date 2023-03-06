/*################################# AGREGAR ROL #################################*/

$(document).on("click", ".agregar", function () {
  var row = $(this).closest("tr").find(".form-control");
//Buscamos el nombre del rol que vamos a agregar
  var descripcion = row[1].value;
  let arreglo = { rodescripcion: descripcion };
  var verificador = false;
  if (arreglo["rodescripcion"] != "") {
    verificador = true;
  }

  if (verificador) {
    console.log(arreglo);
    agregar(arreglo);
  } else {
    // ALERT LIBRERIA
    bootbox.alert({
      message: "No puedes dejar campos vacios!",
      size: "small",
      closeButton: false,
    });
  }
});

function agregar(arreglo) {
  console.log(arreglo);
  $.ajax({
    //Llamamos a la funcion altarol y le enviamos el arreglo con la descripcion, el id es autoincrement
    type: "POST",
    url: "../Acciones/rol/altaRol.php",
    data: arreglo,
    success: function (response) {
      var response = jQuery.parseJSON(response);
      console.log(response);
      if (response) {
        // CARTEL LIBRERIA, ESPERA 1,5 SEG Y LUEGO HACE EL RELOAD
        var dialog = bootbox.dialog({
            message: '<div class="text-center"><i class="fa fa-spin fa-spinner me-2"></i>Agregando Rol...</div>',
            closeButton: false
        });
        dialog.init(function () {
            setTimeout(function () {
                
                location.reload();
                bootbox.hideAll();
            }, 1500);
        });
    } else {
        bootbox.alert({
          message: "Respuesta: " + response,
          size: "small",
          closeButton: false,
        });
      }
    },
  });
}

/*################################# EDITAR ROL #################################*/

$(document).on("click", ".editar", function () {
  //MUESTRA EL FORMULARIO Y PRECARGA LOS DATOS
  document.getElementById("editarRol").classList.remove("d-none");
  var fila = $(this).closest("tr");
  var idrol = fila[0].children[0].innerHTML;
  var rodescripcion = fila[0].children[1].innerHTML;

  var form = document.getElementById("editarR");

  var inputs = form.getElementsByTagName("input");

  document.getElementById("idrol").innerHTML = idrol;
  inputs[0].value = idrol;
  inputs[1].value = rodescripcion;
  
  //var arrayEdit = {'idrol':idrol, 'rodescripcion':rodescripcion};
});

//CIERRA EL FORMULARIO
$(document).on("click", "#cancelar", function () {
  document.getElementById("editarRol").classList.add("d-none");
});

//ENVIA LOS DATOS
$(document).ready(function () {
    $('form').submit(function (e) {
        e.preventDefault();

        $.ajax({
          //Llamamos a la funcion editar con el id y la nueva descripcion del rol
            type: "POST",
            url: '../Acciones/rol/editarRol.php',
            data: $(this).serialize(),
            success: function (response) {
                
                var response = jQuery.parseJSON(response);
                console.log(response);
                if (response) {
                    // CARTEL LIBRERIA, ESPERA 1,5 SEG Y LUEGO HACE EL RELOAD
                    var dialog = bootbox.dialog({
                        message: '<div class="text-center"><i class="fa fa-spin fa-spinner me-2"></i>Editando Rol...</div>',
                        closeButton: false
                    });
                    dialog.init(function () {
                        setTimeout(function () {
                            document.getElementById('editarRol').classList.add('d-none');
                            location.reload();
                            bootbox.hideAll();
                        }, 1500);
                    });
                } else {
                    console.log(response);
                }
            }
        });
    });
});
/*################################# ELIMINAR ROL #################################*/

$(document).on("click", ".eliminar", function () {
  var fila = $(this).closest("tr");
  var idrol = fila[0].children[0].innerHTML;
  var rodescripcion = fila[0].children[1].innerHTML;

  // CARTEL LIBRERIA
  bootbox.confirm({
    title: "Eliminar rol?",
    closeButton: false,
    message:
      "Estas seguro que quieres eliminar al rol " +
      rodescripcion +
      " con ID:" +
      idrol,
    buttons: {
      cancel: {
        className: "btn btn-outline-danger",
        label: '<i class="fa fa-times"></i> Cancelar',
      },
      confirm: {
        className: "btn btn-outline-success",
        label: '<i class="fa fa-check"></i> Confirmar',
      },
    },
    callback: function (result) {
      if (result) {
        eliminar(idrol);
      }
    },
  });
});

function eliminar(idrol) {
  $.ajax({
    //Llamamos a la funcion eliminarRol con el id del rol a eliminar
    type: "POST",
    url: "../Acciones/rol/eliminarRol.php",
    data: { idrol: idrol },
    success: function (response) {
      var response = jQuery.parseJSON(response);
      if (response) {
        // CARTEL LIBRERIA, ESPERA 1,5 SEG Y LUEGO HACE EL RELOAD
        var dialog = bootbox.dialog({
            message: '<div class="text-center"><i class="fa fa-spin fa-spinner me-2"></i>Eliminando Rol...</div>',
            closeButton: false
        });
        dialog.init(function () {
            setTimeout(function () {
               
                location.reload();
                bootbox.hideAll();
            }, 1500);
        });
    } else {
        console.log(response);
      }
    },
  });
}
