<?php 
class menu extends BaseDatos {
private $idmenu;
private $idrol;

private $mensajeoperacion;


public function __construct(){
    parent:: __construct();
    $this->idmenu=new menu();
    $this->idrol=new rol();
   
    $this->mensajeoperacion ="";
}

public function setear($idmenu, $idrol) {
    $this->setIdmenu($idmenu);
    $this->setIdrol($idrol);

}

public function cargar(){
    $resp = false;
    
    $sql="SELECT * FROM menurol WHERE idmenu = '".$this->getIdmenu()->getID()."'";
    if ($this->Iniciar()) {
        $res = $this->Ejecutar($sql);
        if($res>-1){
            if($res>0){
                $row = $this->Registro();
                $rol = new rol();
                $rol->setIdRol($row['idrol']);
                $rol->cargar();
                $menu = new menu();
                $menu->setID($row['idmenu']);
                $menu->cargar();
                $this->setear($menu, $rol);
            }
        }
    } else {
        $this->setMensajeoperacion("menurol->listar: ".$this->getError());
    }
    return $resp;
}

public function insertar(){
    $resp = false;
    
    // Si lleva ID Autoincrement, la consulta SQL no lleva Patente. Y viceversa:
    $sql="INSERT INTO menurol(idmenu, idrol)
        VALUES('"
        .$this->getIdmenu()->getID()."', '"
        .$this->getIdrol()->getIdRol()."');";
    if ($this->Iniciar()) {
        if ($this->Ejecutar($sql)) {
            $resp = true;
        } else {
            $this->setMensajeoperacion("menurol->insertar: ".$this->getError());
        }
    } else {
        $this->setMensajeoperacion("menurol->insertar: ".$this->getError());
    }
    return $resp;
}

public function modificar(){
    $resp = false;
    
   
    $sql="UPDATE menurol SET idrol='".$this->getIdrol()->getIdRol(). "' WHERE idmenu=".$this->getIdmenu()->getID()."";
   
    if ($this->Iniciar()) {
        if ($this->Ejecutar($sql)) {
            $resp = true;
         
        } else {
            $this->setMensajeoperacion("menurol->modificar: ".$this->getError());
        }
    } else {
        $this->setMensajeoperacion("menurol->modificar: ".$this->getError());
    }
    return $resp;
}

public function eliminar(){
    $resp = false;
    
    $sql="DELETE FROM menurol WHERE idmenu=".$this->getIdmenu()->getID()."";
    if ($this->Iniciar()) {
        if ($this->Ejecutar($sql)) {
            $resp = true;
        } else {
            $this->setMensajeoperacion("menurol->eliminar: ".$this->getError());
        }
    } else {
        $this->setMensajeoperacion("menurol->eliminar: ".$this->getError());
    }
    return $resp;
}

public function listar($parametro=""){
    $arreglo = array();
    
    $sql="SELECT DISTINCT * FROM menurol ";
   
    
    if ($parametro!="") {
        $sql.= "WHERE ".$parametro;
    }
    
    
    $res = $this->Ejecutar($sql);
    if($res>-1){
        if($res>0){
            while ($row = $this->Registro()){
                $menu= new menu();
                $menu->setID($row['idmenu']);
                $menu->cargar();
                $rol = new Rol();
                $rol->setIdRol($row['idrol']);
                $rol->cargar();
                $row->setear($menu, $rol);
                array_push($arreglo, $row);
            }
        }
    } else {
        $this->setMensajeoperacion("menu->listar: ".$this->getError());
    }
    

    return $arreglo;
}
    
// -- Métodos get y set --





/**
 * Get the value of idmenu
 */ 
public function getIdmenu()
{
return $this->idmenu;
}

/**
 * Set the value of idmenu
 *
 * @return  self
 */ 
public function setIdmenu($idmenu)
{
$this->idmenu = $idmenu;

return $this;
}

/**
 * Get the value of idrol
 */ 
public function getIdrol()
{
return $this->idrol;
}

/**
 * Set the value of idrol
 *
 * @return  self
 */ 
public function setIdrol($idrol)
{
$this->idrol = $idrol;

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
