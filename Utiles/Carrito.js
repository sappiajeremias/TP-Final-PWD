window.onload=function(){
    // SETEAMOS EL ROL ACTIVO PARA POSTERIORMENTE VERIFICAR FUNCIONES CON EL CARRITO
    const elemento = document.getElementById("rolactivo").textContent;
    const roldescripcion = elemento
    sessionStorage.setItem('rolactivo', roldescripcion);
}