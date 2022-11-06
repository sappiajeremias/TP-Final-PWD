<?php 
include_once('../configuracion.php');
 $obj = new abmRol();

 $x = $obj->buscar();

 echo "<hr><br>";

 

 $z = $obj->buscar(['idrol' => 1]);

 echo "<br>";
 print_r($z[0]);
 echo "<br>";echo "<br>";
 echo "<hr><br>";

 echo "<h1>".$z[0]->getRoldescripcion()."</h1>" ;

 echo "<hr><br>";
$z[0]->setRoldescripcion('recep');
if($obj->modificacion($z)){
    echo "Hola Todo Bien";
}else{
    echo "nada";
}

echo "<hr><br>";
echo "<hr><br>";
$j= $obj->buscar(['roldescripcion'=> 'admin']);

$objJ = ['idrol'=>$j[0]->getIdrol(),'roldescripcion'=>$j[0]->getRolDescripcion()];
if($obj->alta($objJ)){
    echo  "se dio de alta";
}else{
    echo "nada alta";
}

echo "<hr><br>";echo "<hr><br>";

$j= $obj->buscar(['roldescripcion'=> 'admin']);

echo "<hr><br>";
echo "<hr><br>";echo "<hr><br>";
echo "<hr><br>";







?>