


// ELIMINAR MENU

$(document).on("click", ".eliminar", function () {
  var fila = $(this).closest("tr");
  var idmenu = fila[0].children[0].innerHTML;
  var menombre = fila[0].children[1].innerHTML;
 


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
    url: "./accionMenu/eliminarMenu.php?",
    data: { idmenu: idmenu },
    success: function (response) {
      console.log(response);
      var response = jQuery.parseJSON(response);
      if (response.respuesta) {
        // CARTEL LIBRERIA, ESPERA 1,5 SEG Y LUEGO HACE EL RELOAD
        var dialog = bootbox.dialog({
          message:
            '<div class="text-center"><i class="fa fa-spin fa-spinner me-2"></i>Borrando Menu...</div>',
          closeButton: false,
        });
        dialog.init(function () {
          setTimeout(function () {
            location.reload();
          }, 1500);
        });
      } else {
        console.log(response.respuesta);
      }
    },
  });
}

// AGREGAR MENU

$(document).on("click", ".agregar", function () {
  var fila = $(this).closest("tr").find("input");
  //var fila_tipo = fila.find('input[type=radio]');

  var nombre = fila[1].value;
  var detalle = fila[2].value;
  var idpadre = fila[3].value;

  if (idpadre === "") {
    arreglo = {
      menombre: nombre,
      medescripcion: detalle,
    };
  } else {
    arreglo = {
      menombre: nombre,
      medescripcion: detalle,
      idpadre: idpadre,
    };
  }
  console.log(nombre, detalle, idpadre);

  var verificador = true;

  $.each(arreglo, function (index, value) {
    if (value === "") {
      verificador = false;
    }
  });

  if (verificador) {
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

function agregar(array) {
  $.ajax({
    type: "POST",
    url: "./accionMenu/agregarMenu.php",
    data: array,
    success: function (response) {
      console.log(response);
      var response = jQuery.parseJSON(response);

      if (response.respuesta) {
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

$(document).on('click','.editar', function () {
  document.getElementById('editarMenu').classList.remove('d-none');
  
  var fila = $(this).closest('tr');
  var idMenu,menombre,medescripcion,idpadre
 /*  $.each(fila, function (index, value) { 
    console.log(value);     
  }); */
  idMenu = fila[0].children[0].innerHTML;
  menombre = fila[0].children[1].innerHTML;
  medescripcion = fila[0].children[2].innerHTML;
  idpadre = fila[0].children[3].innerHTML;
  medeshabilitado = fila[0].children[4].innerHTML;
  

  
  var form = document.getElementById('editarM');
  var inputs = form.getElementsByTagName('input');

  document.getElementById('idmenu').innerHTML = idMenu;



  inputs[0].value = idMenu;
  inputs[1].value = menombre;
  inputs[2].value = medescripcion;  
  inputs[3].value = medeshabilitado;
  inputs[4].value = idpadre;
  

});

$(document).on('click','#cancelar',function(){
  document.getElementById('editarMenu').classList.add('d-none');
}); 


$(document).ready(function () {
  $('form').submit(function (e) { 
    e.preventDefault();

    $.ajax({
      type: "POST",
      url: "./accionMenu/editarMenu.php",
      data: $(this).serialize() ,

      success: function (response) {
        
        var response = jQuery.parseJSON(response);  
        
        if(response.respuesta){
          var dialog = bootbox.dialog({
            message: '<div class="text-center"><i class="fa fa-spin fa-spinner me-2"></i>Editando Producto...</div>',
            closeButton: false
          });
          dialog.init(function(){
            setTimeout(function() {
              location.reload();              
            }, 1500);
          })
        }else{
          console.log(response.respuesta);
        }        
      }
    });
    
  });
});