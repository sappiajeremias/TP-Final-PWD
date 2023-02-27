//################################### LISTAR MENUES ################################
$(window).on("load", function () {
  cargarMenues();
});

function cargarMenues() {
  $.ajax({
    type: "POST",
    url: './accion/menurol/listarMenues.php',
    data: null,
    success: function (response) {
      //console.log(response);
      var arreglo = [];
      $.each($.parseJSON(response), function (index, menuActual) {
        arreglo.push(menuActual);
      });

      armarTabla(arreglo);
    }
  });
}

// Buscamos la tabla y añadimos cada menú
function armarTabla(arreglo) {
  // VACIAMOS LA TABLA
  $('#tablaMenu > tbody').empty();
  // AGREGAMOS LOS PRODUCTOS
  $.each(arreglo, function (index, menu) {
    if (menu.medescripcion === "#") {
      if (menu.hijos) {
        boton = '<a href="#"><button class="agregarHijo btn btn-outline-info mx-2" data-bs-toggle="modal" data-bs-target="#agregar-modal-hijo">Agregar Hijos</button></a>';
      } else {
        boton = '<a href="#"><button class="agregarHijo btn btn-outline-info mx-2" data-bs-toggle="modal" data-bs-target="#agregar-modal-hijo">Agregar Hijos</button></a><a href="#"><button class="convertirSimple btn btn-outline-warning mx-2">Convertir en Enlace Simple</button></a><a href="#"><button class="eliminar btn btn-outline-danger mx-2">Eliminar</button></a>';
      }
    } else {
      boton = '<a href="#"><button class="convertirPadre btn btn-outline-success mx-2">Convertir en Padre</button></a><button class="eliminar btn btn-outline-danger mx-2">Eliminar</button></a>'
    }

    $('#tablaMenu > tbody:last-child').append('<tr><th scope="row">' + menu.id + '</th><th scope="row">' + menu.idpadre + '</th><td>' + menu.menombre + '</td><td>' + menu.medescripcion + '</td><td>' + menu.rol + '</td><td>' + boton + '</td></tr>');

    //<button type="button" class="editarButton btn btn-outline-warning mx-2" data-bs-toggle="modal" data-bs-target="#editar-modal-producto"><i class="fa-solid fa-file-pen"></i></button><a href="#"><button class="deshabilitar btn btn-outline-danger"><i class="fa-solid fa-trash"></i></button></a>
  });
}

//################################### AGREGAR HIJO ################################
$(document).on("click", ".agregarHijo", function () {
  var fila = $(this).closest("tr");
  idmenu = fila[0].children[0].innerHTML;
  $('#idpadre').val(idmenu);
});

$('#agregarHijo').submit(function (e) {
  e.preventDefault();
  $.ajax({
    type: "POST",
    url: './accion/menurol/agregarHijo.php',
    data: $(this).serialize(),
    success: function (response) {
      console.log(response);
      var response = jQuery.parseJSON(response);
      if (response) {
        var dialog = bootbox.dialog({
          message:
            '<div class="text-center"><i class="fa fa-spin fa-spinner me-2"></i>Agregando Hijo Menú...</div>',
          closeButton: false,
        });
        dialog.init(function () {
          setTimeout(function () {
            cargarMenues();
            bootbox.hideAll();
          }, 1000);
        });
      } else {
        bootbox.alert({
          message: "Error al cargar Hijo Menú",
          size: 'small',
          closeButton: false,
        });
      }
    }
  });
});

//################################### CONVERTIR EN PADRE ################################
$(document).on("click", ".convertirPadre", function () {
  var fila = $(this).closest("tr");
  idmenu = fila[0].children[0].innerHTML;
  //console.log(idmenu);

  // CARTEL LIBRERIA
  bootbox.confirm({
    title: "Habilitar Opción de Agregar Hijos?",
    closeButton: false,
    message: "Estas seguro que quieres convertir en padre al menu con ID: <b>" + idmenu + "</b> ?",
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
        cambiarDescripcion(idmenu, "#");
      }
    },
  });
});

//################################### CONVERTIR EN ENLACE SIMPLE ################################
$(document).on("click", ".convertirSimple", function () {
  var fila = $(this).closest("tr");
  idmenu = fila[0].children[0].innerHTML;
  //console.log(idmenu);

  // CARTEL LIBRERIA
  bootbox.prompt({
    title: "Convertir en un Enlace Simple?",
    closeButton: false,
    message: "Estas seguro que quieres convertir en enlace simple al menu con ID: <b>" + idmenu + "</b> ?",
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
    inputType: 'select',
    inputOptions: [{
      text: 'Tabla Menu Roles',
      value: '../Admin/tablaMenuRoles.php'
    },
    {
      text: 'Tabla Roles',
      value: '../Admin/tablaRoles.php'
    },
    {
      text: 'Tabla Usuarios',
      value: '../Admin/tablaUsuarios.php'
    },
    {
      text: 'Ver Carrito',
      value: '../Cliente/carrito.php'
    },
    {
      text: 'Ver Mis Compras',
      value: '../Cliente/listaCompras.php'
    },
    {
      text: 'Ver Mi Perfil',
      value: '../Cliente/modificarPerfil.php'
    },
    {
      text: 'Tabla Compras',
      value: '../Deposito/tablaCompras.php'
    },
    {
      text: 'Tabla Productos',
      value: '../Deposito/tablaProductos.php'
    }],
    callback: function (result) {
      cambiarDescripcion(idmenu, result);
    },
  });
});

function cambiarDescripcion(idmenu, descripcion) {
  $.ajax({
    type: "POST",
    url: "./accion/menurol/menuDescripcion.php",
    data: { idmenu: idmenu, descripcion: descripcion },
    success: function (response) {
      console.log(response);
      var response = jQuery.parseJSON(response);
      if (response) {
        // CARTEL LIBRERIA, ESPERA 1,5 SEG Y LUEGO HACE EL RELOAD
        var dialog = bootbox.dialog({
          message:
            '<div class="text-center"><i class="fa fa-spin fa-spinner me-2"></i>Convirtiendo Menu...</div>',
          closeButton: false,
        });
        dialog.init(function () {
          setTimeout(function () {
            cargarMenues();
            bootbox.hideAll();
          }, 1000);
        });
      } else {
        console.log(response);
      }
    },
  });
}

/*################################# AGREGAR MENÚ RAÍZ #################################*/
$('#agregar').submit(function (e) {
  e.preventDefault();
  $.ajax({
    type: "POST",
    url: './accion/menurol/agregarMenu.php',
    data: $(this).serialize(),
    success: function (response) {
      console.log(response);
      var response = jQuery.parseJSON(response);
      if (response) {
        var dialog = bootbox.dialog({
          message:
            '<div class="text-center"><i class="fa fa-spin fa-spinner me-2"></i>Agregando Menú...</div>',
          closeButton: false,
        });
        dialog.init(function () {
          setTimeout(function () {
            cargarMenues();
            bootbox.hideAll();
          }, 1000);
        });
      } else {
        bootbox.alert({
          message: "Error al cargar Menú",
          size: 'small',
          closeButton: false,
        });
      }
    }
  });
});


//################################### ELIMINAR MENÚ ################################

$(document).on("click", ".eliminar", function () {
  var fila = $(this).closest("tr");
  var idmenu = fila[0].children[0].innerHTML;
  var menombre = fila[0].children[2].innerHTML;

  // CARTEL LIBRERIA
  bootbox.confirm({
    title: "Eliminar Menu ?",
    closeButton: false,
    message:
      "Estas seguro que quieres eliminar a " +
      menombre +
      " con ID: <b>" +
      idmenu +
      "</b>",
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
        eliminar(idmenu);
      }
    },
  });
});

function eliminar(idmenu) {
  $.ajax({
    type: "POST",
    url: "./accion/menurol/eliminar.php?",
    data: { idmenu: idmenu },
    success: function (response) {
      console.log(response);
      var response = jQuery.parseJSON(response);
      if (response) {
        // CARTEL LIBRERIA, ESPERA 1,5 SEG Y LUEGO HACE EL RELOAD
        var dialog = bootbox.dialog({
          message:
            '<div class="text-center"><i class="fa fa-spin fa-spinner me-2"></i>Eliminando Menu...</div>',
          closeButton: false,
        });
        dialog.init(function () {
          setTimeout(function () {
            cargarMenues();
            bootbox.hideAll();
          }, 1000);
        });
      } else {
        console.log(response);
      }
    },
  });
}
/*
//################################### DESHABILITAR MENÚ ################################

$(document).on("click", ".deshabilitar", function () {
  var fila = $(this).closest("tr");
  var idmenu = fila[0].children[0].innerHTML;
  var menombre = fila[0].children[1].innerHTML;
  var idpadre = fila[0].children[3].innerHTML;

  if (idpadre === "") {
    bootbox.alert({
      message: "No puedes deshabilitar menu padre!",
      size: "small",
      closeButton: false,
    });
  } else {
    // CARTEL LIBRERIA
    bootbox.confirm({
      title: "Deshabilitar Menu ?",
      closeButton: false,
      message:
        "Estas seguro que quieres deshabilitar a " +
        menombre +
        " con ID: <b>" +
        idmenu +
        "</b>",
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
          eliminar(idmenu);
        }
      },
    });
  }
});

function eliminar(idmenu) {
  $.ajax({
    type: "POST",
    url: "./accionMenu/eliminarMenu.php?",
    data: { idmenu: idmenu, accion: "deshabilitar" },
    success: function (response) {
      console.log(response);
      var response = jQuery.parseJSON(response);
      if (response) {
        // CARTEL LIBRERIA, ESPERA 1,5 SEG Y LUEGO HACE EL RELOAD
        var dialog = bootbox.dialog({
          message:
            '<div class="text-center"><i class="fa fa-spin fa-spinner me-2"></i>Deshabilitar Menu...</div>',
          closeButton: false,
        });
        dialog.init(function () {
          setTimeout(function () {
            location.reload();
          }, 1500);
        });
      } else {
        console.log(response);
      }
    },
  });
}

//################################### AGREGAR MENÚ ################################
function agregar(array) {
  $.ajax({
    type: "POST",
    url: "./accionMenu/agregarMenu.php",
    data: array,
    success: function (response) {
      console.log(response);
      var response = jQuery.parseJSON(response);

      if (response) {
        // CARTEL LIBRERIA, ESPERA 1,5 SEG Y LUEGO HACE EL RELOAD
        var dialog = bootbox.dialog({
          message:
            '<div class="text-center"><i class="fa fa-spin fa-spinner me-2"></i>Cargando Producto...</div>',
          closeButton: false,
        });
        dialog.init(function () {
          setTimeout(function () {
            location.reload();
          }, 1500);
        });
      } else {
        bootbox.alert({
          message: "Respuesta: No Se Pudo",
          size: "small",
          closeButton: false,
        });
      }
    },
  });
}

// MODIFICAR MENU

$(document).on("click", ".editar", function () {
  document.getElementById("editarMenu").classList.remove("d-none");

  var fila = $(this).closest("tr");
  var idMenu, menombre, medescripcion, idpadre;
  /*  $.each(fila, function (index, value) { 
    console.log(value);     
  }); 
  idMenu = fila[0].children[0].innerHTML;
  menombre = fila[0].children[1].innerHTML;
  medescripcion = fila[0].children[2].innerHTML;
  idpadre = fila[0].children[3].innerHTML;
  rol = fila[0].children[4].innerHTML;
  medeshabilitado = fila[0].children[5].innerHTML;

  var i = 0;
  var bool = true;
  var form = document.getElementById("editarM");
  var inputs = form.getElementsByTagName("input");
  var option = form.getElementsByTagName("option");

  if (idpadre !== "") {
    document.getElementById("padre").style.display = "block";
    document.getElementById("selecRol").style.display = "none";
  } else {
    document.getElementById("selecRol").style.display = "block";
    document.getElementById("padre").style.display = "none";
  }

  while (bool && i < option.length) {
    if (option[i].text == rol) {
      option[i].setAttribute("selected", true);
    }
    i++;
  }

  document.getElementById("idmenu").innerHTML = idMenu;

  inputs[0].value = idMenu;
  inputs[1].value = menombre;
  inputs[2].value = medescripcion;
  inputs[3].value = medeshabilitado;
  inputs[4].value = idpadre;
});

$(document).on("click", "#cancelar", function () {
  document.getElementById("editarMenu").classList.add("d-none");
});

$(document).ready(function () {
  $("form").submit(function (e) {
    e.preventDefault();
    console.log($(this).serialize());

    $.ajax({
      type: "POST",
      url: "./accionMenu/editarMenu.php",
      data: $(this).serialize(),

      success: function (response) {
        console.log(response);
        var response = jQuery.parseJSON(response);

        if (response) {
          var dialog = bootbox.dialog({
            message:
              '<div class="text-center"><i class="fa fa-spin fa-spinner me-2"></i>Editando Producto...</div>',
            closeButton: false,
          });
          dialog.init(function () {
            setTimeout(function () {
              location.reload();
            }, 1500);
          });
        } else {
          console.log(response);
        }
      },
    });
  });
});*/