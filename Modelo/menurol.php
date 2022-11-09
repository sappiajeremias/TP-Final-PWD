<?php 
class menuRol extends BaseDatos {

private $objmenu;
private $objrol;
private $mensajeoperacion;


public function __construct(){

    parent:: __construct();
    $this->objmenu="";
    $this->objrol="";
    $this->mensajeoperacion ="";
}

public function setear($newObjMenu, $newObjRol) {
    $this->setObjMenu($newObjMenu);
    $this->setObjRol($newObjRol);

}

public function cargar(){
    $resp = false;
    
    $sql="SELECT * FROM menurol WHERE idmenu = '".$this->getObjMenu()->getID()."'";
    if ($this->Iniciar()) {
        $res = $this->Ejecutar($sql);
        if($res>-1){
            if($res>0){
                $row = $this->Registro();

                $rol = new rol();
                $rol->setID($row['idrol']);
                $rol->cargar();

                $menu = new menu();
                $menu->setID($row['idmenu']);
                $menu->cargar();

                $this->setear($menu, $rol);
            }
        }
    } else {
        $this->setMensajeOperacion("menurol->listar: ".$this->getError());
    }
    return $resp;
}

public function insertar(){
    $resp = false;
    
    // Si lleva ID Autoincrement, la consulta SQL no lleva Patente. Y viceversa:
    $sql="INSERT INTO menurol(idmenu, idrol)
        VALUES('"
        .$this->getObjMenu()->getID()."', '"
        .$this->getObjRol()->getID()."');";
    if ($this->Iniciar()) {
        if ($this->Ejecutar($sql)) {
            $resp = true;
        } else {
            $this->setMensajeOperacion("menurol->insertar: ".$this->getError());
        }
    } else {
        $this->setMensajeOperacion("menurol->insertar: ".$this->getError());
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
            $this->setMensajeOperacion("menurol->modificar: ".$this->getError());
        }
    } else {
        $this->setMensajeOperacion("menurol->modificar: ".$this->getError());
    }
    return $resp;
}

public function eliminar(){
    $resp = false;
    
    $sql="DELETE FROM menurol WHERE idmenu=".$this->getObjMenu()->getID()."";
    if ($this->Iniciar()) {
        if ($this->Ejecutar($sql)) {
            $resp = true;
        } else {
            $this->setMensajeOperacion("menurol->eliminar: ".$this->getError());
        }
    } else {
        $this->setMensajeOperacion("menurol->eliminar: ".$this->getError());
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
                $rol->setID($row['idrol']);
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
public function getObjMenu()
{
return $this->objmenu;
}

/**
 * Set the value of idmenu
 *
 * @return  self
 */ 
public function setObjMenu($newObjMenu)
{
$this->objmenu = $newObjMenu;

return $this;
}

/**
 * Get the value of idrol
 */ 
public function getObjRol()
{
return $this->objrol;
}

/**
 * Set the value of idrol
 *
 * @return  self
 */ 
public function setObjRol($newObjRol)
{
$this->objrol = $newObjRol;

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
