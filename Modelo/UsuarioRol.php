<?php   

class usuarioRol extends BaseDatos{

    private $objUsuario;
    private $objRol;
    private $mensajeOperacion;

    public function __construct(){
        $this->objUsuario= new Usuario();
        $this->objRol= new Rol();
        $this->mensajeOperacion="";
    }

    public function setear($objUsuario, $objRol){
        $this->setObjUsuario($objUsuario);
        $this->setObjRol($objRol);
    }

    //MÉTODOS PROPIOS DE LA CLASE

    public function cargar(){
        $resp = false;
        $base=new BaseDatos();
        $idUsuario=$this->getObjUsuario()->getIdusuario();
        $sql="SELECT * FROM usuariorol WHERE idusuario = ".$idUsuario;
        if ($base->Iniciar()) {
            $res = $base->Ejecutar($sql);
            if($res>-1){
                if($res>0){
                    $row = $base->Registro();
                    $objUsuario= new Usuario();
                    $objRol= new Rol();
                    $objUsuario->setIdUsuario($row['idusuario']);
                    $objRol->setIdRol($row['idrol']);
                    $objUsuario->cargar();
                    $objRol->cargar();
                    $this->setear($objUsuario, $objRol);
                }
            }
        } else {
            $this->setMensajeOperacion("usuariorol->listar: ".$base->getError());
        }
        return $resp;
    }
    
    public function insertar(){
        $resp = false;
        $base=new BaseDatos();
        // Si lleva ID Autoincrement, la consulta SQL no lleva dicho ID
        $sql="INSERT INTO usuariorol(idusuario, idrol) 
            VALUES('"
            .$this->getObjUsuario()->getIdUsuario()."', '"
            .$this->getObjRol()->getIdRol()."'
        );";
        if ($base->Iniciar()) {
            if ($esteid = $base->Ejecutar($sql)) {
                // Si se usa ID autoincrement, descomentar lo siguiente:
                //$this->setidusuario($esteid);
                $resp = true;
            } else {
                $this->setMensajeOperacion("usuariorol->insertar: ".$base->getError());
            }
        } else {
            $this->setMensajeOperacion("usuariorol->insertar: ".$base->getError());
        }
        return $resp;
    }
    
    public function modificar(){
        $resp = false;
        /*$base=new BaseDatos();
        $idUsuario=$this->getObjUsuario()->getIdUsuario();
        $idRol=$this->getObjRol()->getIdRol();
        $sql="UPDATE usuariorol SET idrol='".$idRol."' WHERE idusuario=".$idUsuario."AND idrol=".$idRol;
        if ($base->Iniciar()) {
            if ($base->Ejecutar($sql)) {
                $resp = true;
            } else {
                $this->setMensajeOperacion("usuariorol->modificar: ".$base->getError());
            }
        } else {
            $this->setMensajeOperacion("usuariorol->modificar: ".$base->getError());
        }*/
        return $resp;
    }
    
    public function eliminar(){
        $resp = false;
        $base=new BaseDatos();
        $idUsuario=$this->getObjUsuario()->getIdUsuario();
        $idRol=$this->getObjRol()->getIdRol();
        $sql="DELETE FROM usuariorol WHERE idusuario=".$idUsuario."AND idrol=".$idRol;
        if ($base->Iniciar()) {
            if ($base->Ejecutar($sql)) {
                return true;
            } else {
                $this->setMensajeOperacion("usuariorol->eliminar: ".$base->getError());
            }
        } else {
            $this->setMensajeOperacion("usuariorol->eliminar: ".$base->getError());
        }
        return $resp;
    }
    
    public static function listar($parametro=""){
        $arreglo = array();
        $base=new BaseDatos();
        $sql="SELECT * FROM usuariorol ";
        if ($parametro!="") {
            $sql.='WHERE '.$parametro;
        }
        $res = $base->Ejecutar($sql);
        if($res>-1){
            if($res>0){
                while ($row = $base->Registro()){
                    $objUsuarioRol= new usuarioRol();
                    $objUsuario= new usuario();
                    $objRol= new rol();
                    $objUsuario->setIdUsuario($row['idusuario']);
                    $objUsuario->cargar();
                    $objRol->setIdRol($row['idrol']);
                    $objRol->cargar();
                    $objUsuarioRol->setear($objUsuario, $objRol);
                    array_push($arreglo, $objUsuarioRol);
                }
            }
        } else {
            $this->setMensajeOperacion("usuariorol->listar: ".$base->getError());
        }
    
        return $arreglo;
    }

    //MÉTODOS GET
    public function getObjUsuario(){
        return $this->objUsuario;
    }

    public function getObjRol(){
        return $this->objRol;
    }

    public function getMensajeOperacion(){
        return $this->mensajeOperacion;
    }

    //MÉTODOS SET
    public function setObjUsuario($newObjUsuario){
        $this->objUsuario=$newObjUsuario;
        return $this;
    }
    public function setObjRol($newObjRol){
        $this->objRol=$newObjRol;
        return $this;
    }
    public function setMensajeOperacion($newMensajeOperacion){
        $this->mensajeOperacion=$newMensajeOperacion;
        return $this;
    }


}
?>