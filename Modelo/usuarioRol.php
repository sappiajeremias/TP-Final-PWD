<?php   

class usuarioRol extends BaseDatos{

    private $objusuario;
    private $objrol;
    private $mensajeOperacion;

    public function __construct(){
        parent:: __construct();
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
        $idUsuario=$this->getObjUsuario()->getID();
        $sql="SELECT * FROM usuariorol WHERE idusuario = ".$idUsuario;
        if ($this->Iniciar()) {
            $res = $this->Ejecutar($sql);
            if($res>-1){
                if($res>0){
                    $row = $this->Registro();
                    $objUsuario= new Usuario();
                    $objRol= new Rol();

                    $objUsuario->setID($row['idusuario']);
                    $objRol->setIdRol($row['idrol']);

                    $objUsuario->cargar();
                    $objRol->cargar();

                    $this->setear($objUsuario, $objRol);
                }
            }
        } else {
            $this->setMensajeOperacion("usuariorol->listar: ".$this->getError());
        }
        return $resp;
    }
    
    public function insertar(){
        $resp = false;
        // Si lleva ID Autoincrement, la consulta SQL no lleva dicho ID
        $sql="INSERT INTO usuariorol(idusuario, idrol) 
            VALUES('"
            .$this->getObjUsuario()->getID()."', '"
            .$this->getObjRol()->getID()."'
        );";
        if ($this->Iniciar()) {
            if ($esteid = $this->Ejecutar($sql)) {
                // Si se usa ID autoincrement, descomentar lo siguiente:
                //$this->setidusuario($esteid);
                $resp = true;
            } else {
                $this->setMensajeOperacion("usuariorol->insertar: ".$this->getError());
            }
        } else {
            $this->setMensajeOperacion("usuariorol->insertar: ".$this->getError());
        }
        return $resp;
    }
    
    public function modificar(){
        return false;
    }
    
    public function eliminar(){
        $resp = false;
        $idUsuario=$this->getObjUsuario()->getID();
        $idRol=$this->getObjRol()->getID();
        $sql="DELETE FROM usuariorol WHERE idusuario = ".$idUsuario." AND idrol = ".$idRol;
        if ($this->Iniciar()) {
            if ($this->Ejecutar($sql)) {
                return true;
            } else {
                $this->setMensajeOperacion("usuariorol->eliminar: ".$this->getError());
            }
        } else {
            $this->setMensajeOperacion("usuariorol->eliminar: ".$this->getError());
        }
        return $resp;
    }

    public function listar($parametro = "")
    {
        $arreglo = array();
        $sql = "SELECT * FROM usuariorol ";
        if ($parametro != "") {
            $sql .= " WHERE " . $parametro;
        }
        if ($this->Iniciar()) {
            
            $res = $this->Ejecutar($sql);

            if ($res > -1) {
                

                if ($res > 0) {


                    while ($row = $this->Registro()) {

                        $objUsuarioRol = new usuarioRol();
                        $objUsuario = new usuario();
                        $objRol = new rol();

                        $objUsuario->setID($row['idusuario']);
                        $objUsuario->cargar();

                        $objRol->setIdRol($row['idrol']);
                        $objRol->cargar();

                        $objUsuarioRol->setear($objUsuario, $objRol);
                        array_push($arreglo, $objUsuarioRol);
                    }
                }
            } else {
                $this->setMensajeOperacion("usuariorol->listar: " . $this->getError());
            }
        }

        return $arreglo;
    }

    public function setearConClave($param){
        $this->getObjRol()->setIdRol($param['idrol']);
        $this->getObjUsuario()->setID($param['idusuario']);
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
