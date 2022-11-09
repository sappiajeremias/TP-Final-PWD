<?php

include_once('./Estructura/cabecera.php');

/* login($sesion); */


$data = data_submitted();
if (array_key_exists('usnombre', $data) && array_key_exists('uspass', $data)) {
  if (isset($data['usnombre']) && isset($data['uspass'])) {
    print_r($_SESSION);
    echo $data['usnombre'];
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
  <div class="card">
  <div class="card-header">
    Grupo 1
  </div>
  <div class="card-body">
    <h5 class="card-title">Bienvenido</h5>
    <p class="card-text">El sitio de las oportunidades</p>
    <a href="./Index_login.php" class="btn btn-primary">Ingresar</a>
  </div>
  <div class="card-footer text-muted">
    proximamente desarrolladores de verdad.
  </div>
</div>
  </main>
  <footer>
    <!-- place footer here -->
  </footer>
  <!-- Bootstrap JavaScript Libraries -->
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js" integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous">
  </script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.min.js" integrity="sha384-7VPbUDkoPSGFnVtYi0QogXtr74QeVeeIs99Qfg5YCF+TidwNdjvaKZX19NZ/e6oz" crossorigin="anonymous">
  </script>
  <script>
  </script>

</body>

</html>