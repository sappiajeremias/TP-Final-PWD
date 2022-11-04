<?php   
class Usuario extends BaseDatos{

    private $idusuario;
    private $usnombre;
    private $uspass;
    private $usmail;
    private $usdeshabilitado;
    private $mensajeOperacion;

    public function __construct(){
        $this->idusuario="";
        $this->usnombre="";
        $this->uspass="";
        $this->usmail="";
        $this->usdeshabilitado=null;
        $this->mensajeOperacion="";
    }

    public function setear($idusuario,$usnombre,$uspass,$usmail,$usdeshabilitado){
        $this->setIdusuario($idusuario);
        $this->setUsnombre($usnombre);
        $this->setUspass($uspass);
        $this->setUsmail($usmail);
        $this->setUsdeshabilitado($usdeshabilitado);
    }

    //MÉTODOS PROPIOS DE LA CLASE

    public function cargar(){
        $resp = false;
        $base=new BaseDatos();
        $sql="SELECT * FROM usuario WHERE idusuario = ".$this->getIdusuario();
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
            .$this->getUsnombre()."', '"
            .$this->getUspass()."', '"
            .$this->getUsmail()."', '"
            .$this->getUsdeshabilitado()."'
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
        SET usnombre='".$this->getUsnombre()
        ."', uspass='".$this->getUspass()
        ."', usmail='".$this->getUsmail()
        ."', usdeshabilitado='".$this->getUsdeshabilitado()
        ."' WHERE idusuario='".$this->getIdusuario()."'";
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
        $sql="DELETE FROM usuario WHERE idusuario=".$this->getIdusuario();
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
   


    /**
     * Get the value of idusuario
     */ 
    public function getIdusuario()
    {
        return $this->idusuario;
    }

    /**
     * Set the value of idusuario
     *
     * @return  self
     */ 
    public function setIdusuario($idusuario)
    {
        $this->idusuario = $idusuario;

        return $this;
    }

    /**
     * Get the value of usnombre
     */ 
    public function getUsnombre()
    {
        return $this->usnombre;
    }

    /**
     * Set the value of usnombre
     *
     * @return  self
     */ 
    public function setUsnombre($usnombre)
    {
        $this->usnombre = $usnombre;

        return $this;
    }

    /**
     * Get the value of uspass
     */ 
    public function getUspass()
    {
        return $this->uspass;
    }

    /**
     * Set the value of uspass
     *
     * @return  self
     */ 
    public function setUspass($uspass)
    {
        $this->uspass = $uspass;

        return $this;
    }

    /**
     * Get the value of usdeshabilitado
     */ 
    public function getUsdeshabilitado()
    {
        return $this->usdeshabilitado;
    }

    /**
     * Set the value of usdeshabilitado
     *
     * @return  self
     */ 
    public function setUsdeshabilitado($usdeshabilitado)
    {
        $this->usdeshabilitado = $usdeshabilitado;

        return $this;
    }

    /**
     * Get the value of mensajeOperacion
     */ 
    public function getMensajeOperacion()
    {
        return $this->mensajeOperacion;
    }

    /**
     * Set the value of mensajeOperacion
     *
     * @return  self
     */ 
    public function setMensajeOperacion($mensajeOperacion)
    {
        $this->mensajeOperacion = $mensajeOperacion;

        return $this;
    }

    /**
     * Get the value of usmail
     */ 
    public function getUsmail()
    {
        return $this->usmail;
    }

    /**
     * Set the value of usmail
     *
     * @return  self
     */ 
    public function setUsmail($usmail)
    {
        $this->usmail = $usmail;

        return $this;
    }
}    


?>