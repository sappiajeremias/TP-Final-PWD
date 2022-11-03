<?php   
class Usuario{

    private $idUsuario;
    private $usNombre;
    private $usPass;
    private $usMail;
    private $usDeshabilitado;
    private $mensajeOperacion;

    public function __construct(){
        $this->idUsuario="";
        $this->usNombre="";
        $this->usPass="";
        $this->usMail="";
        $this->usDeshabilitado=null;
        $this->mensajeOperacion="";
    }

    public function setear($idUsuario,$usNombre,$usPass,$usMail,$usDeshabilitado){
        $this->setIdUsuario($idUsuario);
        $this->setUsNombre($usNombre);
        $this->setUsPass($usPass);
        $this->setUsMail($usMail);
        $this->setUsDeshabilitado($usDeshabilitado);
    }

    //MÉTODOS PROPIOS DE LA CLASE

    public function cargar(){
        $resp = false;
        $base=new BaseDatos();
        $sql="SELECT * FROM usuario WHERE idusuario = ".$this->getIdUsuario();
        if ($base->Iniciar()) {
            $res = $base->Ejecutar($sql);
            if($res>-1){
                if($res>0){
                    $row = $base->Registro();
                    $this->setear($row['idusuario'], $row['usnombre'], $row['uspass'],
                        $row['usmail'], $row['usdeshabilitado']);
                }
            }
        } else {
            $this->setMensajeOperacion("usuario->listar: ".$base->getError());
        }
        return $resp;
    }
    
    public function insertar(){
        $resp = false;
        $base=new BaseDatos();
        // Si lleva ID Autoincrement, la consulta SQL no lleva dicho ID
        $sql="INSERT INTO usuario(usnombre, uspass, usmail, usdeshabilitado) 
            VALUES('"
            .$this->getUsNombre()."', '"
            .$this->getUsPass()."', '"
            .$this->getUsMail()."', '"
            .$this->getUsDeshabilitado()."'
        );";
        if ($base->Iniciar()) {
            if ($esteid = $base->Ejecutar($sql)) {
                // Si se usa ID autoincrement, descomentar lo siguiente:
                $this->setidusuario($esteid);
                $resp = true;
            } else {
                $this->setMensajeOperacion("usuario->insertar: ".$base->getError());
            }
        } else {
            $this->setMensajeOperacion("usuario->insertar: ".$base->getError());
        }
        return $resp;
    }
    
    public function modificar(){
        $resp = false;
        $base=new BaseDatos();
        $sql="UPDATE usuario 
        SET usnombre='".$this->getUsNombre()
        ."', uspass='".$this->getUsPass()
        ."', usmail='".$this->getUsMail()
        ."', usdeshabilitado='".$this->getUsDeshabilitado()
        ."' WHERE idusuario='".$this->getIdUsuario()."'";
        if ($base->Iniciar()) {
            if ($base->Ejecutar($sql)) {
                $resp = true;
            } else {
                $this->setMensajeOperacion("usuario->modificar: ".$base->getError());
            }
        } else {
            $this->setMensajeOperacion("usuario->modificar: ".$base->getError());
        }
        return $resp;
    }
    
    public function eliminar(){
        $resp = false;
        $base=new BaseDatos();
        $sql="DELETE FROM usuario WHERE idusuario=".$this->getIdUsuario();
        if ($base->Iniciar()) {
            if ($base->Ejecutar($sql)) {
                return true;
            } else {
                $this->setMensajeOperacion("usuario->eliminar: ".$base->getError());
            }
        } else {
            $this->setMensajeOperacion("usuario->eliminar: ".$base->getError());
        }
        return $resp;
    }
    
    public static function listar($parametro=""){
        $arreglo = array();
        $base=new BaseDatos();
        $sql="SELECT * FROM usuario ";
        if ($parametro!="") {
            $sql.='WHERE '.$parametro;
        }
        $res = $base->Ejecutar($sql);
        if($res>-1){
            if($res>0){
                while ($row = $base->Registro()){
                    $obj= new usuario();
                    $obj->setear($row['idusuario'], $row['usnombre'], 
                    $row['uspass'], $row['usmail'], $row['usdeshabilitado']);
                    array_push($arreglo, $obj);
                }
            }
        } else {
            $this->setMensajeOperacion("usuario->listar: ".$base->getError());
        }
    
        return $arreglo;
    }

    //MÉTODOS GET
    public function getIdUsuario(){
        return $this->idUsuario;
    }

    public function getUsNombre(){
        return $this->usNombre;
    }

    public function getUsPass(){
        return $this->usPass;
    }

    public function getUsMail(){
        return $this->usMail;
    }

    public function getUsDeshabilitado(){
        return $this->usDeshabilitado;
    }

    public function getMensajeOperacion(){
        return $this->mensajeOperacion;
    }

    //MÉTODOS SET
    public function setIdUsuario($newIdUsuario){
        $this->idUsuario=$newIdUsuario;
        return $this;
    }
    
    public function setUsNombre($newUsNombre){
        $this->usNombre=$newUsNombre;
        return $this;
    }
    public function setUsPass($newUsPass){
        $this->usPass=$newUsPass;
        return $this;
    }
    public function setUsMail($newUsMail){
        $this->usMail=$newUsMail;
        return $this;
    }
    public function setUsDeshabilitado($newUsDeshabilitado){
        $this->usDeshabilitado=$newUsDeshabilitado;
        return $this;
    }
    public function setMensajeOperacion($newMensajeOperacion){
        $this->mensajeOperacion=$newMensajeOperacion;
        return $this;
    }


}    


?>