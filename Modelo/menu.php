<?php 

class menu extends BaseDatos{

private $idmenu;
private $menombre;
private $medescripcion;
private $objmenupadre;
private $medeshabilitado;
private $mensajeoperacion;


public function __construct(){
    parent :: __construct();
    $this->idmenu="";
    $this->menombre="";
    $this->medescripcion="";
    $this->objmenupadre= null;
    $this->medeshabilitado=null;
    $this->mensajeoperacion ="";
}

public function setear($idmenu, $menombre, $medescripcion, $newObjpadre, $medeshabilitado) {
    $this->setID($idmenu);
    $this->setMeNombre($menombre);
    $this->setMeDescripcion($medescripcion);
    $this->setObjMenuPadre($newObjpadre);
    $this->setMeDeshabilitado($medeshabilitado);
}

public function setearSinID( $menombre, $medescripcion, $newObjpadre, $medeshabilitado) {
    $this->setMeNombre($menombre);
    $this->setMeDescripcion($medescripcion);
    $this->setObjMenuPadre($newObjpadre);
    $this->setMeDeshabilitado($medeshabilitado);
}

public function setearSinPadre($menombre, $medescripcion){
    $objPadre = new menu();
    $this->setMeNombre($menombre);
    $this->setMeDescripcion($medescripcion);
    $this->setObjMenuPadre($objPadre);
}


public function cargar(){
    $resp = false;   
    $sql="SELECT * FROM menu WHERE idmenu = '".$this->getID()."'";
    if ($this->Iniciar()) {
        $res = $this->Ejecutar($sql);
        if($res>-1){
            if($res>0){
                $row = $this->Registro();
                $padre = new menu();
                $padre->setID($row['idpadre']);
                $padre->cargar();

                $this->setear($row['idmenu'], $row['menombre'], $row['medescripcion'], $padre, $row['medeshabilitado']);
            }
        }
    } else {
        $this->setMensajeOperacion("menu->listar: ".$this->getError());
    }
    return $resp;
}

public function insertar(){
    $resp = false;

    $idPadre = $this->getObjMenuPadre() != "" ? "'".$this->getObjMenuPadre()->getID()."'" : 'NULL';
    $deshabilitado= $this->getMeDeshabilitado() != '' ? $this->getMeDeshabilitado() : 'NULL';
      
    // Si lleva ID Autoincrement, la consulta SQL no lleva id. Y viceversa:
    $sql="INSERT INTO menu(menombre, medescripcion, idpadre, medeshabilitado)
        VALUES('"
        .$this->getMeNombre()."', '"
        .$this->getMeDescripcion()."', "
        .$idPadre.", "
        .$deshabilitado.");";
        
    if ($this->Iniciar()) {
        if ($this->Ejecutar($sql)) {
            $resp = true;
        } else {
            $this->setMensajeOperacion("menu->insertar: ".$this->getError());
        }
    } else {
        $this->setMensajeOperacion("menu->insertar: ".$this->getError());
    }
    return $resp;
}


/* public function insertarDos(){
    $resp = false;
      
    // Si lleva ID Autoincrement, la consulta SQL no lleva id. Y viceversa:
    $sql="INSERT INTO menu(menombre, medescripcion)
        VALUES('"
        .$this->getMeNombre()."', '"
        .$this->getMeDescripcion()."');";
    if ($this->Iniciar()) {
        if ($this->Ejecutar($sql)) {
            $resp = true;
        } else {
            $this->setMensajeOperacion("menu->insertar: ".$this->getError());
        }
    } else {
        $this->setMensajeOperacion("menu->insertar: ".$this->getError());
    }
    return $resp;
} */

public function modificarDescripcion(){
    $resp = false;
   
    $sql="UPDATE menu SET medescripcion='".$this->getMeDescripcion()."' WHERE idmenu='".$this->getID()."'";
    
    if ($this->Iniciar()) {
        if ($this->Ejecutar($sql)) {
            $resp = true;
         
        } else {
            $this->setMensajeOperacion("menu->modificar: ".$this->getError());
        }
    } else {
        $this->setMensajeOperacion("menu->modificar: ".$this->getError());
    }
    return $resp;
}

public function modificar(){
    $idPadre = $this->getObjMenuPadre() != null ? "'".$this->getObjMenuPadre()->getID()."'" : 'NULL';
    
    $deshabilitado= $this->getMeDeshabilitado() != '' ? $this->getMeDeshabilitado() : 'NULL';
      
    $resp = false;
   
    $sql="UPDATE menu SET menombre='"
    .$this->getMeNombre()."', medescripcion='"
    .$this->getMeDescripcion()."', medeshabilitado='"
    .$deshabilitado."', idpadre="
    .$idPadre 
    ." WHERE idmenu='".$this->getID()."'";

    
    if ($this->Iniciar()) {
        if ($this->Ejecutar($sql)) {
            $resp = true;
         
        } else {
            $this->setMensajeOperacion("menu->modificar: ".$this->getError());
        }
    } else {
        $this->setMensajeOperacion("menu->modificar: ".$this->getError());
    }
    return $resp;
}

public function eliminar(){
    $resp = false;
   
    $sql="DELETE FROM menu WHERE idmenu=".$this->getID()."";
    if ($this->Iniciar()) {
        if ($this->Ejecutar($sql)) {
            $resp = true;
        } else {
            $this->setMensajeOperacion("menu->eliminar: ".$this->getError());
        }
    } else {
        $this->setMensajeOperacion("menu->eliminar: ".$this->getError());
    }
    return $resp;
}

public function listar($parametro=""){
    $arreglo = array();
    $sql="SELECT * FROM menu ";
    if ($parametro!="") {
        $sql.= "WHERE ".$parametro;
    }
    $res = $this->Ejecutar($sql);
    if($res>-1){
        if($res>0){
            while ($row = $this->Registro()){
                $obj= new menu();
                $padre= new menu();
                
                $padre->setID($row['idpadre']);
                $padre->cargar();

                $obj->setear($row['idmenu'], $row['menombre'], $row['medescripcion'], $padre, $row['medeshabilitado']);
                array_push($arreglo, $obj);
            }
        }
    } else {
        $this->setMensajeOperacion("menu->listar: ".$this->getError());
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
public function getMeNombre()
{
return $this->menombre;
}

/**
 * Set the value of menombre
 *
 * @return  self
 */ 
public function setMeNombre($menombre)
{
$this->menombre = $menombre;

return $this;
}

/**
 * Get the value of medescripcion
 */ 
public function getMeDescripcion()
{
return $this->medescripcion;
}

/**
 * Set the value of medescripcion
 *
 * @return  self
 */ 
public function setMeDescripcion($medescripcion)
{
$this->medescripcion = $medescripcion;

return $this;
}

/**
 * Get the value of idpadre
 * @return object
 */ 
public function getObjMenuPadre()
{
return $this->objmenupadre;
}

/**
 * Set the value of idpadre
 *
 * @return  self
 */ 
public function setObjMenuPadre($newObjMenuPadre)
{
$this->objmenupadre = $newObjMenuPadre;

return $this;
}

/**
 * Get the value of medeshabilitado
 */ 
public function getMeDeshabilitado()
{
return $this->medeshabilitado;
}

/**
 * Set the value of medeshabilitado
 *
 * @return  self
 */ 
public function setMeDeshabilitado($medeshabilitado)
{
$this->medeshabilitado = $medeshabilitado;

return $this;
}

/**
 * Get the value of mensajeoperacion
 */ 
public function getMensajeOperacion()
{
return $this->mensajeoperacion;
}

/**
 * Set the value of mensajeoperacion
 *
 * @return  self
 */ 
public function setMensajeOperacion($mensajeoperacion)
{
$this->mensajeoperacion = $mensajeoperacion;

return $this;
}
}
