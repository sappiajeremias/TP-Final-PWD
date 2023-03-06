$(window).on("load", function () {
    cargarProductosHome();
});

function cargarProductosHome(){
    //console.log("carrito");
    $.ajax({
        type: "POST",
        url: '../Acciones/producto/listarProdTienda.php',
        data: null,
        success: function (response) {
            //console.log(response);
            var arreglo = [];
            $.each($.parseJSON(response), function (index, productoActual) {
                    arreglo.push(productoActual);
            });
            //console.log(arreglo);

            armarTablaProductos(arreglo);
        }
    });
}

// Buscamos la tabla y añadimos cada compra
function armarTablaProductos(arreglo) {


    $('#filaProductos').empty();
    //console.log(arreglo.length);
    
    if((arreglo.length)>0){ 
        //var idcompra=arreglo[0].idcompra;
        //console.log(idcompra);
    $.each(arreglo, function (index, producto) {

            $('#filaProductos').append('<div class="col-sm-3 pb-3" ><div  class="card" id="listaProductos"><div class="card-body text-center"><div class="card-body text-center"><img src="./img/productos/'+producto.imagen+'"class="rounded float-start mb-2" width="250" height="200"><h5 class="card-title">'+producto.pronombre+'</h5><p class="card-text">'+producto.prodetalle+'</p><p class="card-text"><b>Precio:</b> '+producto.precio+'</p><p class="card-text"><b>Stock Actual: </b>'+producto.procantstock+'</p><div id="agregarBoton'+producto.idproducto+'" class="d-grid gap-2 d-md-block m-auto mb-2"></div></div></div></div></div>');
        

        if(producto.rol !=null && producto.rol=="cliente"){
            $('#agregarBoton'+producto.idproducto).append('<button class="carrito btn btn-outline-success" type="button" onclick=agregarACarrito('+producto.idproducto+') class="agregarACarrito btn btn-primary btn-sm">Añadir al carrito</button>');
              
        }
    });

    
}else{
    
    $('#filaProductos').append('<div class=" card mb-3" style="max-width: 540px;"><div class="row g-0"><div class="col-md-4"><img src="./img/logo_black.svg" class="img-fluid rounded-start" alt="..."></div><div class="col-md-8"><div class="card-body"><h4 class="card-title">Todav&iacutea estamos cargando los productos...</h4><p class="card-text">Falta muy poco para que veas todos los productos que tenemos para vos!.</p></div></div></div></div>');
}
}
