<?php $Titulo = "TP5 - Login";
include_once("./Estructura/cabecera.php");

$data = data_submitted();
$msj = "";

if (!empty($data['accion'])) {
  if ($data['accion'] == 'vacio') {
    $msj = "<div class='card'>
              <div class='card-body bg-warning text-center '>
                  <h3>Ingresar los datos</h3>
              </div>
            </div>";
  }
  if ($data['accion'] == 'invalido') {
    $msj = "<div class='card'>
              <div class='card-body bg-warning text-center '>
                  <h3>Ingresar datos validos</h3>
              </div>
            </div>";
  }
}


?>

<!doctype html>
<html lang="en">

<head>
  <title>Title</title>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

  <!-- Bootstrap CSS v5.2.1 -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous">

</head>

<body>
  <header>
    <!-- place navbar here -->
  </header>
  <main>
    <?php if ($msj != "") {
      echo $msj;
    } ?>
    <form action="./Control_Logueo.php" method="post" name="login">
      <div class="row d-flex justify-content-center">
        <div class="col-sm-4">
          <div class="card">
            <div class="card-body">
              <h3 class="card-title">Loguin</h3>
              <div class="col-md-4">
                <label for="usnombre" class="form-label">Usuario</label>
                <input type="text" class="form-control w-100" name="usnombre" id="usnombre" value="" require>
              </div>
              <div class="col-md-4">
                <label for="uspass" class="form-label">Password</label>
                <input type="password" class="form-control" name="uspass" id="uspass" value="" require>
              </div>
              <button type="submit" class="btn btn-outline-success mt-2">Ingresar</button>
            </div>
          </div>
        </div>
      </div>
    </form>

  </main>
  <footer>
    <!-- place footer here -->
  </footer>
  <!-- Bootstrap JavaScript Libraries -->
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js" integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous">
  </script>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.min.js" integrity="sha384-7VPbUDkoPSGFnVtYi0QogXtr74QeVeeIs99Qfg5YCF+TidwNdjvaKZX19NZ/e6oz" crossorigin="anonymous"></script>

</body>

</html>