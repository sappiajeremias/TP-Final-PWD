<?php 
class menu extends BaseDatos{
private $idmenu;
private $menombre;
private $medescripcion;
private $idpadre;
private $medeshabilitado;
private $mensajeoperacion;


public function __construct(){
    $this->idmenu="";
    $this->menombre="";
    $this->medescripcion="";
    $this->idpadre="";
    $this->medeshabilitado=null;
    $this->mensajeoperacion ="";
}

public function setear($idmenu, $menombre, $medescripcion, $idpadre, $medeshabilitado) {
    $this->setID($idmenu);
    $this->setMenombre($menombre);
    $this->setMedescripcion($medescripcion);
    $this->setIdpadre($idpadre);
    $this->setMedeshabilitado($medeshabilitado);
}

public function cargar(){
    $resp = false;
    $base=new BaseDatos();
    $sql="SELECT * FROM menu WHERE idmenu = '".$this->getID()."'";
    if ($base->Iniciar()) {
        $res = $base->Ejecutar($sql);
        if($res>-1){
            if($res>0){
                $row = $base->Registro();
                $padre = new menu();
                $padre->setID($row['idpadre']);
                $padre->cargar();
                $this->setear($row['idmenu'], $row['menombre'], $row['medescripcion'], $padre, $row['medeshabilitado']);
            }
        }
    } else {
        $this->setMensajeoperacion("menu->listar: ".$base->getError());
    }
    return $resp;
}

public function insertar(){
    $resp = false;
    $base=new BaseDatos();
    // Si lleva ID Autoincrement, la consulta SQL no lleva Patente. Y viceversa:
    $sql="INSERT INTO menu(menombre, medescripcion, idpadre, medeshabilitado)
        VALUES('"
        .$this->getMenombre()."', '"
        .$this->getMedescripcion()."', '"
        .$this->getIdpadre()->getID()."', '"
        .$this->getMedeshabilitado()."');";
    if ($base->Iniciar()) {
        if ($base->Ejecutar($sql)) {
            $resp = true;
        } else {
            $this->setMensajeoperacion("menu->insertar: ".$base->getError());
        }
    } else {
        $this->setMensajeoperacion("menu->insertar: ".$base->getError());
    }
    return $resp;
}

public function modificar(){
    $resp = false;
    $base=new BaseDatos();
    $idpadre =$this->getIdpadre()->getID();
   
    $sql="UPDATE menu SET menombre='".$this->getMenombre()."', medescripcion='".$this->getMedescripcion()."', 
    idpadre='".$idpadre."', medeshabilitado='".$this->getMedeshabilitado() . "' WHERE idmenu=".$this->getId()."";
   
    if ($base->Iniciar()) {
        if ($base->Ejecutar($sql)) {
            $resp = true;
         
        } else {
            $this->setMensajeoperacion("menu->modificar: ".$base->getError());
        }
    } else {
        $this->setMensajeoperacion("menu->modificar: ".$base->getError());
    }
    return $resp;
}

public function eliminar(){
    $resp = false;
    $base=new BaseDatos();
    $sql="DELETE FROM menu WHERE idmenu=".$this->getID()."";
    if ($base->Iniciar()) {
        if ($base->Ejecutar($sql)) {
            $resp = true;
        } else {
            $this->setMensajeoperacion("menu->eliminar: ".$base->getError());
        }
    } else {
        $this->setMensajeoperacion("menu->eliminar: ".$base->getError());
    }
    return $resp;
}

public static function listar($parametro=""){
    $arreglo = array();
    $base=new BaseDatos();
    $sql="SELECT * FROM menu ";
   
    
    if ($parametro!="") {
        $sql.= "WHERE ".$parametro;
    }
    
    
    $res = $base->Ejecutar($sql);
    if($res>-1){
        if($res>0){
            while ($row = $base->Registro()){
                $padre= new menu();
                $padre->setID($row['idpadre']);
                $padre->cargar();
                $obj->setear($row['idmenu'], $row['menombre'], $row['medescripcion'], $idpadre, $row['medeshabilitado']);
                array_push($arreglo, $obj);
            }
        }
    } else {
        $this->setMensajeoperacion("menu->listar: ".$base->getError());
    }
    

    return $arreglo;
}
    
// -- Métodos get y set --



/**
 * Get the value of idmenu
 */ 
public function getID()
{
return $this->idmenu;
}

/**
 * Set the value of idmenu
 *
 * @return  self
 */ 
public function setID($idmenu)
{
$this->idmenu = $idmenu;

return $this;
}

/**
 * Get the value of menombre
 */ 
public function getMenombre()
{
return $this->menombre;
}

/**
 * Set the value of menombre
 *
 * @return  self
 */ 
public function setMenombre($menombre)
{
$this->menombre = $menombre;

return $this;
}

/**
 * Get the value of medescripcion
 */ 
public function getMedescripcion()
{
return $this->medescripcion;
}

/**
 * Set the value of medescripcion
 *
 * @return  self
 */ 
public function setMedescripcion($medescripcion)
{
$this->medescripcion = $medescripcion;

return $this;
}

/**
 * Get the value of idpadre
 */ 
public function getIdpadre()
{
return $this->idpadre;
}

/**
 * Set the value of idpadre
 *
 * @return  self
 */ 
public function setIdpadre($idpadre)
{
$this->idpadre = $idpadre;

return $this;
}

/**
 * Get the value of medeshabilitado
 */ 
public function getMedeshabilitado()
{
return $this->medeshabilitado;
}

/**
 * Set the value of medeshabilitado
 *
 * @return  self
 */ 
public function setMedeshabilitado($medeshabilitado)
{
$this->medeshabilitado = $medeshabilitado;

return $this;
}

/**
 * Get the value of mensajeoperacion
 */ 
public function getMensajeoperacion()
{
return $this->mensajeoperacion;
}

/**
 * Set the value of mensajeoperacion
 *
 * @return  self
 */ 
public function setMensajeoperacion($mensajeoperacion)
{
$this->mensajeoperacion = $mensajeoperacion;

return $this;
}
} 


?>