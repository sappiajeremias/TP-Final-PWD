<?php
class compraItem extends BaseDatos{

    //ver los diferentes estados de la compra y sus posibles contextos de cambio 
    //hacer la extensión con la BD

    private $idcompraitem;
    private $idproducto;
    private $idcompra;
    private $cicantidad;
    private $mensajeoperacion;

    public function __construct(){
        $this->idcompraitem="";
        $this->idproducto="";
        $this->idcompra="";
        $this->cicantidad="";
        $this->mensajeOperacion="";
    }

    public function setear($idcompraitem,$idproducto,$idcompra,$cicantidad){
        $this->setID($idcompraitem);
        $this->setIdproducto($idproducto);
        $this->setIdcompra($idcompra);
        $this->setCicantidad($cicantidad);
    }

    //MÉTODOS PROPIOS DE LA CLASE

    public function cargar(){
        $resp = false;
        $base=new BaseDatos();
        $sql="SELECT * FROM compraitem WHERE idcompraitem = ".$this->getID();
        if ($base->Iniciar()) {
            $res = $base->Ejecutar($sql);
            if($res>-1){
                if($res>0){
                    $row = $base->Registro();
                    $objproducto= new producto();
                    $objcompra= new compra();
                    $objproducto->setID($row['idproducto']);
                    $objcompra->setID($row['idcompra']);
                    $objproducto->cargar();
                    $objcompra->cargar();
                    $this->setear($row['idcompraitem'], $objproducto, $objcompra,$row['cicantidad']);
                }
            }
        } else {
            $this->setMensajeOperacion("compraitem->listar: ".$base->getError());
        }
        return $resp;
    }
    
    public function insertar(){
        //Fecha ini poner fecha actual
        //Setear fecha fin cuando el admin apruebe la compra (fecha)
        $resp = false;
        $base=new BaseDatos();
        // Si lleva ID Autoincrement, la consulta SQL no lleva dicho ID
        $sql="INSERT INTO compraitem(idproducto, idcompra, cicantidad) 
            VALUES('"
            .$this->getIdproducto()->getID()."', '"
            .$this->getIdcompra()->getID()."', '"
            .$this->getCicantidad()."'
        );";
        if ($base->Iniciar()) {
            if ($esteid = $base->Ejecutar($sql)) {
                // Si se usa ID autoincrement, descomentar lo siguiente:
                $this->setId($esteid);
                $resp = true;
            } else {
                $this->setMensajeOperacion("compraitem->insertar: ".$base->getError());
            }
        } else {
            $this->setMensajeOperacion("compraitem->insertar: ".$base->getError());
        }
        return $resp;
    }
    
    public function modificar(){
        $resp = false;
        $base=new BaseDatos();
        $sql="UPDATE compraitem 
        SET idproducto='".$this->getIdproducto()->getID()
        ."', idcompra='".$this->getIdcompra()->getID()
        ."', cicantidad='".$this->getCicantidad()
        ."' WHERE idcompraitem='".$this->getID()."'";
        if ($base->Iniciar()) {
            if ($base->Ejecutar($sql)) {
                $resp = true;
            } else {
                $this->setMensajeOperacion("compraitem->modificar: ".$base->getError());
            }
        } else {
            $this->setMensajeOperacion("compraitem->modificar: ".$base->getError());
        }
        return $resp;
    }
    
    public function eliminar(){
        $resp = false;
        $base=new BaseDatos();
        $sql="DELETE FROM compraitem WHERE idcompraitem=".$this->getID();
        if ($base->Iniciar()) {
            if ($base->Ejecutar($sql)) {
                return true;
            } else {
                $this->setMensajeOperacion("compraitem->eliminar: ".$base->getError());
            }
        } else {
            $this->setMensajeOperacion("compraitem->eliminar: ".$base->getError());
        }
        return $resp;
    }
    
    public static function listar($parametro=""){
        $arreglo = array();
        $base=new BaseDatos();
        $sql="SELECT * FROM compraitem ";
        if ($parametro!="") {
            $sql.='WHERE '.$parametro;
        }
        $res = $base->Ejecutar($sql);
        if($res>-1){
            if($res>0){
                while ($row = $base->Registro()){
                    $obj= new compraItem();
                    $objCompra = new compra();
                    $objProducto= new producto();
                    $objCompra->setID($row['idcompra']);
                    $objProducto->setID($row['idproducto']);
                    $objCompra->cargar();
                    $objProducto->cargar();
                    $obj->setear($row['idcompraitem'], $objProducto, 
                    $objCompra, $row['cicantidad']);
                    array_push($arreglo, $obj);
                }
            }
        } else {
            $this->setMensajeOperacion("compraitem->listar: ".$base->getError());
        }
    
        return $arreglo;
    }

    //MÉTODOS GET
    

    public function getMensajeOperacion(){
        return $this->mensajeoperacion;
    }

    //MÉTODOS SET
    
    public function setMensajeOperacion($newMensajeOperacion){
        $this->mensajeoperacion=$newMensajeOperacion;
        return $this;
    }


    

    /**
     * Get the value of idcompraitem
     */ 
    public function getID()
    {
        return $this->idcompraitem;
    }

    /**
     * Set the value of idcompraitem
     *
     * @return  self
     */ 
    public function setID($idcompraitem)
    {
        $this->idcompraitem = $idcompraitem;

        return $this;
    }

    /**
     * Get the value of idproducto
     */ 
    public function getIdproducto()
    {
        return $this->idproducto;
    }

    /**
     * Set the value of idproducto
     *
     * @return  self
     */ 
    public function setIdproducto($idproducto)
    {
        $this->idproducto = $idproducto;

        return $this;
    }

    /**
     * Get the value of idcompra
     */ 
    public function getIdcompra()
    {
        return $this->idcompra;
    }

    /**
     * Set the value of idcompra
     *
     * @return  self
     */ 
    public function setIdcompra($idcompra)
    {
        $this->idcompra = $idcompra;

        return $this;
    }

    /**
     * Get the value of cicantidad
     */ 
    public function getCicantidad()
    {
        return $this->cicantidad;
    }

    /**
     * Set the value of cicantidad
     *
     * @return  self
     */ 
    public function setCicantidad($cicantidad)
    {
        $this->cicantidad = $cicantidad;

        return $this;
    }
}


?>