<?php
class compraEstado extends BaseDatos{

    //ver los diferentes estados de la compra y sus posibles contextos de cambio 
    //hacer la extensión con la BD

    private $idcompraestado;
    private $objcompra;
    private $objcompraestadotipo;
    private $cefechaini; //CURRENT_TIMESTAMP
    private $cefechafin;
    private $mensajeoperacion;

    public function __construct(){
        parent::__construct();
        $this->idcompraestado="";
        $this->objcompra="";
        $this->objcompraestadotipo="";
        $this->cefechaini=date('Y-m-d H:i:s');
        $this->cefechafin=null;
        $this->mensajeOperacion="";
    }

    public function setear($idcompraestado,$objcompra,$objcompraestadotipo,$cefechaini,$cefechafin){
        $this->setID($idcompraestado);
        $this->setObjCompra($objcompra);
        $this->setObjCompraEstadoTipo($objcompraestadotipo);
        $this->setCeFechaIni($cefechaini);
        $this->setCeFechaFin($cefechafin);
    }

    public function setearSinID($objcompra,$objcompraestadotipo,$cefechaini,$cefechafin){
        $this->setObjCompra($objcompra);
        $this->setObjCompraEstadoTipo($objcompraestadotipo);
        $this->setCeFechaIni($cefechaini);
        $this->setCeFechaFin($cefechafin);
    }

    //MÉTODOS PROPIOS DE LA CLASE

    public function cargar(){
        $resp = false;
        $sql="SELECT * FROM compraestado WHERE idcompraestado = ".$this->getID();
        if ($this->Iniciar()) {
            $res = $this->Ejecutar($sql);
            if($res>-1){
                if($res>0){
                    $row = $this->Registro();
                    $objcompra= new compra();
                    $objcompraestadotipo= new compraEstadoTipo();
                    
                    $objcompra->setID($row['idcompra']);
                    $objcompraestadotipo->setID($row['idcompraestadotipo']);

                    $objcompra->cargar();
                    $objcompraestadotipo->cargar();

                    $this->setear($row['idcompraestado'], $objcompra, $objcompraestadotipo,$row['cefechaini'], $row['cefechafin']);
                }
            }
        } else {
            $this->setMensajeOperacion("compraestado->listar: ".$this->getError());
        }
        return $resp;
    }
    
    public function insertar(){
        //Fecha ini poner fecha actual
        //Setear fecha fin cuando el admin apruebe la compra (fecha)
        $resp = false;
        // Si lleva ID Autoincrement, la consulta SQL no lleva dicho ID
        $sql="INSERT INTO compraestado(idcompra, idcompraestadotipo, cefechaini, cefechafin) 
            VALUES('"
            .$this->getObjCompra()->getID()."', '"
            .$this->getObjCompraEstadoTipo()->getID()."', '"
            .$this->getCeFechaIni()."', '"
            .$this->getCeFechaFin()."'
        );";
        if ($this->Iniciar()) {
            if ($esteid = $this->Ejecutar($sql)) {
                // Si se usa ID autoincrement, descomentar lo siguiente:
                $this->setID($esteid);
                $resp = true;
            } else {
                $this->setMensajeOperacion("compraestado->insertar: ".$this->getError());
            }
        } else {
            $this->setMensajeOperacion("compraestado->insertar: ".$this->getError());
        }
        return $resp;
    }
    
    public function modificar(){
        $resp = false;
        $sql="UPDATE compraestado 
        SET idcompra='".$this->getObjCompra()->getID()
        ."', idcompraestadotipo='".$this->getObjCompraEstadoTipo()->getID()
        ."', cefechaini='".$this->getCeFechaIni()
        ."', cefechafin='".$this->getCeFechaFin()
        ."' WHERE idcompraestado='".$this->getID()."'";
        if ($this->Iniciar()) {
            if ($this->Ejecutar($sql)) {
                $resp = true;
            } else {
                $this->setMensajeOperacion("compraestado->modificar: ".$this->getError());
            }
        } else {
            $this->setMensajeOperacion("compraestado->modificar: ".$this->getError());
        }
        return $resp;
    }
    
    public function eliminar(){
        $resp = false;
        $sql="DELETE FROM compraestado WHERE idcompraestado=".$this->getID();
        if ($this->Iniciar()) {
            if ($this->Ejecutar($sql)) {
                return true;
            } else {
                $this->setMensajeOperacion("compraestado->eliminar: ".$this->getError());
            }
        } else {
            $this->setMensajeOperacion("compraestado->eliminar: ".$this->getError());
        }
        return $resp;
    }
    
    public function listar($parametro=""){
        $arreglo = array();
        $sql="SELECT * FROM compraestado ";
        if ($parametro!="") {
            $sql.='WHERE '.$parametro;
        }
        $res = $this->Ejecutar($sql);
        if($res>-1){
            if($res>0){
                while ($row = $this->Registro()){
                    $obj= new compraEstado();
                    $objCompra = new compra();
                    $objCompraEstadoTipo= new compraEstadoTipo();

                    $objCompra->setID($row['idcompra']);
                    $objCompraEstadoTipo->setID($row['idcompraestadotipo']);

                    $objCompra->cargar();
                    $objCompraEstadoTipo->cargar();

                    $obj->setear($row['idcompraestado'], $objCompra, 
                    $objCompraEstadoTipo, $row['cefechaini'], $row['cefechafin']);
                    array_push($arreglo, $obj);
                }
            }
        } else {
            $this->setMensajeOperacion("compraestado->listar: ".$this->getError());
        }
    
        return $arreglo;
    }

    //MÉTODOS GET
    public function getID(){
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
    public function setID($newId){
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