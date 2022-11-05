<?php

include_once("./Estructura/cabecera.php");

$abUR = new abmUsuarioRol();
/* $abU = new abmUsuario;
$abR = new abmRol(); */

$obj = $abUR->buscar(null);

$arreAdmin = array();
$arreUser = array();

print_r($obj);




?>

<!doctype html>
<html lang="es">

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
        <?php
         foreach ($obj as $key => $value) { 
            
            if ($value->getObjRol()->getIdRol() == 1){

                array_push($arreAdmin, $value);                  
            }else{
                array_push($arreUser,$value);
            }
        }

        ?>




            <div class="table-responsive-sm">
                <table class="table table-striped
        table-hover	
        table-borderless
        table-primary
        align-middle">
                    <thead class="table-light">
                        <caption>Table Name</caption>
                        <tr><?php foreach ($arreAdmin as $key => $valor) {?>
                            
                        
                            <th><?php echo $valor->getObjUsuario()->getIdUsuario(); ?></th>
                            <th><?php echo $valor->getObjUsuario()->getUsNombre(); ?></th>
                            <th><?php echo $valor->getObjUsuario()->getUsPass(); ?></th>
                            <th><?php echo $valor->getObjRol()->getIdRol(); ?> </th>
                            <th><?php echo $valor->getObjRol()->getRolDescripcion(); ?></th>
                            
                        <?php }?>
                        </tr>

                    </thead>
                   
                </table>
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
</body>

</html>