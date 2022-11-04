<?php $Titulo = "TP5 - Login";
include_once("../configuracion.php");
?>

<form name="login" id="login" method="post" action="./Accion/verificarLogin.php">
<div class="mb-3">
  <label for="usnombre" class="form-label">Nombre</label>
  <input type="text"
    class="form-control" name="usnombre" id="" aria-describedby="helpId" placeholder="">
</div>
<div class="mb-3">
  <label for="contraseña" class="form-label">Contraseña</label>
  <input type="password" class="form-control" name="contraseña" id="" placeholder="">
</div>
<button type="submit" class="btn btn-primary">Submit</button>
</form>