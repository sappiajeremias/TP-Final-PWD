<?php
class CompraEstado extends BaseDatos{

    //ver los diferentes estados de la compra y sus posibles contextos de cambio 
    //hacer la extensión con la BD

    private $idcompraestado;
    private $objcompra;
    private $objcompraestadotipo;
    private $cefechaini;
    private $cefechafin;
    private $mensajeoperacion;

    public function __construct(){
        $this->idcompraestado="";
        $this->idcompra="";
        $this->idcompraestadotipo="";
        $this->cefechaini=null;
        $this->cefechafin=null;
        $this->mensajeOperacion="";
    }

    public function setear($idcompraestado,$objcompra,$objcompraestadotipo,$cefechaini,$cefechafin){
        $this->setId($idcompraestado);
        $this->setObjCompra($objcompra);
        $this->setObjCompraEstadoTipo($objcompraestadotipo);
        $this->setCeFechaIni($cefechaini);
        $this->setCeFechaFin($cefechafin);
    }

    //MÉTODOS PROPIOS DE LA CLASE

    public function cargar(){
        $resp = false;
        $base=new BaseDatos();
        $sql="SELECT * FROM compraestado WHERE idcompraestado = ".$this->getId();
        if ($base->Iniciar()) {
            $res = $base->Ejecutar($sql);
            if($res>-1){
                if($res>0){
                    $row = $base->Registro();
                    $objcompra= new Compra();
                    $objcompraestadotipo= new CompraEstadoTipo();
                    $objcompra->setId($row['idcompra']);
                    $objcompraestadotipo->setId($row['idcompraestadotipo']);
                    $objcompra
                    $this->setear($row['idcompraestado'], $objcompra, $objcompraestadotipo,$row['cefechaini'], $row['cefechafin']);
                }
            }
        } else {
            $this->setMensajeOperacion("compraestado->listar: ".$base->getError());
        }
        return $resp;
    }
    
    public function insertar(){
        //Fecha ini poner fecha actual
        //Setear fecha fin cuando el admin apruebe la compra (fecha)
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
    public function getId(){
        return $this->idcompraestado;
    }

    public function getObjCompra(){
        return $this->objcompra;
    }

    public function getObjCompraEstadoTipo(){
        return $this->objcompraestadotipo;
    }

    public function getCeFechaIni(){
        return $this->cefechaini;
    }

    public function getCeFechaFin(){
        return $this->cefechafin;
    }

    public function getMensajeOperacion(){
        return $this->mensajeoperacion;
    }

    //MÉTODOS SET
    public function setId($newId){
        $this->idcompraestado=$newId;
        return $this;
    }
    
    public function setObjCompra($newObjCompra){
        $this->objcompra=$newObjCompra;
        return $this;
    }
    public function setObjCompraEstadoTipo($newObjCompraEstadoTipo){
        $this->objcompraestadotipo=$newObjCompraEstadoTipo;
        return $this;
    }
    public function setCeFechaIni($newCeFechaIni){
        $this->cefechaini=$newCeFechaIni;
        return $this;
    }
    public function setCeFechaFin($newCeFechaFin){
        $this->cefechafin=$newCeFechaFin;
        return $this;
    }
    public function setMensajeOperacion($newMensajeOperacion){
        $this->mensajeoperacion=$newMensajeOperacion;
        return $this;
    }


    
}


?>