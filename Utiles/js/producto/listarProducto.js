$(window).on("load", function () {
    $.ajax({
        type: "POST",
        url: './accion/listarProductos.php',
        data: null,
        success: function (response) {
            $.each($.parseJSON(response), function (index, value) {
                console.log(index);
                console.log(value);
            });
        }
    });
});
$(function() {
    $.ajax({
        type: "POST",
        url: './accion/listarProductos.php',
        data: null,
        success: function (response) {
            $.each($.parseJSON(response), function (index, value) {
                console.log(index);
                console.log(value);
            });
        }
    });
});
$( document ).ready(function() {
    $.ajax({
        type: "POST",
        url: './accion/listarProductos.php',
        data: null,
        success: function (response) {
            $.each($.parseJSON(response), function (index, value) {
                console.log(index);
                console.log(value);
            });
        }
    });
});