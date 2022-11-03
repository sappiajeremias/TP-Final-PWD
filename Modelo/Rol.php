<?php

class Rol{

    private $idRol;
    private $rolDescripcion;
    private $mensajeOperacion;

    public function __construct(){
        $this->idRol="";
        $this->rolDescripcion="";
        $this->mensajeOperacion="";
    }

    public function setear($idRol, $rolDescripcion){
        $this->setIdRol($idRol);
        $this->setRolDescripcion($rolDescripcion);

    }

    //MÉTODOS PROPIOS DE LA CLASE

    public function cargar(){
        $resp = false;
        $base=new BaseDatos();
        $sql="SELECT * FROM rol WHERE idrol = ".$this->getIdRol();
        if ($base->Iniciar()) {
            $res = $base->Ejecutar($sql);
            if($res>-1){
                if($res>0){
                    $row = $base->Registro();
                    $this->setear($row['idrol'], $row['roldescripcion']);
                }
            }
        } else {
            $this->setMensajeOperacion("rol->cargar: ".$base->getError());
        }
        return $resp;
    }
    
    public function insertar(){
        $resp = false;
        $base=new BaseDatos();
        // Si lleva ID Autoincrement, la consulta SQL no lleva dicho ID
        $sql="INSERT INTO rol(roldescripcion) 
            VALUES('"
            .$this->getRolDescripcion()."'
        );";
        if ($base->Iniciar()) {
            if ($esteid = $base->Ejecutar($sql)) {
                // Si se usa ID autoincrement, descomentar lo siguiente:
                $this->setidusuario($esteid);
                $resp = true;
            } else {
                $this->setMensajeOperacion("rol->insertar: ".$base->getError());
            }
        } else {
            $this->setMensajeOperacion("rol->insertar: ".$base->getError());
        }
        return $resp;
    }
    
    public function modificar(){
        $resp = false;
        $base=new BaseDatos();
        $sql="UPDATE rol 
        SET roldescripcion='".$this->getRolDescripcion().
        "' WHERE idrol='".$this->getIdRol()."'";
        if ($base->Iniciar()) {
            if ($base->Ejecutar($sql)) {
                $resp = true;
            } else {
                $this->setMensajeOperacion("rol->modificar: ".$base->getError());
            }
        } else {
            $this->setMensajeOperacion("rol->modificar: ".$base->getError());
        }
        return $resp;
    }
    
    public function eliminar(){
        $resp = false;
        $base=new BaseDatos();
        $sql="DELETE FROM rol WHERE idrol=".$this->getIdRol();
        if ($base->Iniciar()) {
            if ($base->Ejecutar($sql)) {
                return true;
            } else {
                $this->setMensajeOperacion("rol->eliminar: ".$base->getError());
            }
        } else {
            $this->setMensajeOperacion("rol->eliminar: ".$base->getError());
        }
        return $resp;
    }
    
    public static function listar($parametro=""){
        $arreglo = array();
        $base=new BaseDatos();
        $sql="SELECT * FROM rol ";
        if ($parametro!="") {
            $sql.='WHERE '.$parametro;
        }
        $res = $base->Ejecutar($sql);
        if($res>-1){
            if($res>0){
                while ($row = $base->Registro()){
                    $obj= new rol();
                    $obj->setear($row['idrol'], $row['roldescripcion']);
                    array_push($arreglo, $obj);
                }
            }
        } else {
            $this->setMensajeOperacion("rol->listar: ".$base->getError());
        }
    
        return $arreglo;
    }


    //MÉTODOS GET
    public function getIdRol(){
        return $this->idRol;
    }

    public function getRolDescripcion(){
        return $this->rolDescripcion;
    }

    public function getMensajeOperacion(){
        return $this->mensajeOperacion;
    }

    //MÉTODOS SET
    public function setIdRol($newIdRol){
        $this->idRol=$newIdRol;
        return $this;
    }

    public function setRolDescripcion($newRolDescripcion){
        $this->rolDescripcion=$newRolDescripcion;
        return $this;

    }
    public function setMensajeOperacion($newMensajeOperacion){
        $this->mensajeOperacion=$newMensajeOperacion;
        return $this;
    }
}
?>