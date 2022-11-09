<?php 

include_once ('../configuracion.php');

    $obj = new abmUsuario();
    $x = $obj->buscar(['idusuario'=>1]);

    print_r($x);

    echo "<h1>".$x[0]->getIdusuario()."</h1>";
    echo "<h1>".$x[0]->getUsnombre()."</h1>";
    echo "<h1>".$x[0]->getUspass()."</h1>";
    echo "<h1>".$x[0]->getUsmail() . "</h1>";

if ($obj->baja(['idusuario' => 1])) {
    echo "<br/><h1>Se borro</h1>";
}

$i=['idusuario'=>1,'usnombre'=>'Lu','uspass'=>'aaaaa','usmail'=>'luna@lcdh.com'];
/* if ($obj->alta($i)){
    echo "<h1><b>Hola</b></h1>";
} */

/* if($obj->modificacion($i)){
    echo "<h1><b>Chau</b></h1>";
}else{
    echo "ada";
} */

echo "<hr><br>";
echo "<hr><br>";

$ur = $obj->DarRol(['idusuario'=>'2']);
 
echo "<h1>{$ur[0]->getObjUsuario()->getIdusuario()}</h1>";
echo "<h1>{$ur[0]->getObjRol()->getIdrol()}</h1>";



?>
