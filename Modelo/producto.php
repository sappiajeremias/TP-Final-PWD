<?php

class compra extends BaseDatos
{
    //ver los diferentes estados de la compra y sus posibles contextos de cambio
    //hacer la extensión con la BD

    private $idproducto;
    private $pronombre; 
    private $prodetalle;
    private $procantstock;
    private $mensajeoperacion;

    public function __construct()
    {
        $this->idproducto="";
        $this->pronombre="";
        $this->prodetalle="";
        $this->procantstock="";
        $this->mensajeOperacion="";
    }

    public function setear($idproducto, $pronombre, $prodetalle, $procantstock)
    {
        $this->setID($idproducto);
        $this->setPronombre($pronombre);
        $this->setProdetalle($prodetalle);
        $this->setProcantstock($procantstock);
    }

    //MÉTODOS PROPIOS DE LA CLASE

    public function cargar()
    {
        $resp = false;
        $base=new BaseDatos();
        $sql="SELECT * FROM producto WHERE idproducto = ".$this->getID();
        if ($base->Iniciar()) {
            $res = $base->Ejecutar($sql);
            if ($res>-1) {
                if ($res>0) {
                    $row = $base->Registro();
                    
                    $this->setear($row['idproducto'], $row['pronombre'], $row['prodetalle'], $row['procantstock']);
                }
            }
        } else {
            $this->setMensajeOperacion("producto->listar: ".$base->getError());
        }
        return $resp;
    }

    public function insertar()
    {
        //Fecha ini poner fecha actual
        //Setear fecha fin cuando el admin apruebe la compra (fecha)
        $resp = false;
        $base=new BaseDatos();
        // Si lleva ID Autoincrement, la consulta SQL no lleva dicho ID
        $sql="INSERT INTO producto(pronombre, prodetalle, procantstock) 
            VALUES('"
            .$this->getPronombre()."', '"
            .$this->getProdetalle()."', '"
            .$this->getProcantstock()."'
        );";
        if ($base->Iniciar()) {
            if ($esteid = $base->Ejecutar($sql)) {
                // Si se usa ID autoincrement, descomentar lo siguiente:
                $this->setID($esteid);
                $resp = true;
            } else {
                $this->setMensajeOperacion("producto->insertar: ".$base->getError());
            }
        } else {
            $this->setMensajeOperacion("producto->insertar: ".$base->getError());
        }
        return $resp;
    }

    public function modificar()
    {
        $resp = false;
        $base=new BaseDatos();
        $sql="UPDATE producto 
        SET pronombre='".$this->getPronombre()
        ."', prodetalle='".$this->getProdetalle()
        ."', procantstock='". $this->getProcantstock()
        ."' WHERE idproducto='".$this->getID()."'";
        if ($base->Iniciar()) {
            if ($base->Ejecutar($sql)) {
                $resp = true;
            } else {
                $this->setMensajeOperacion("producto->modificar: ".$base->getError());
            }
        } else {
            $this->setMensajeOperacion("producto->modificar: ".$base->getError());
        }
        return $resp;
    }

    public function eliminar()
    {
        $resp = false;
        $base=new BaseDatos();
        $sql="DELETE FROM producto WHERE idproducto=".$this->getID();
        if ($base->Iniciar()) {
            if ($base->Ejecutar($sql)) {
                return true;
            } else {
                $this->setMensajeOperacion("producto->eliminar: ".$base->getError());
            }
        } else {
            $this->setMensajeOperacion("producto->eliminar: ".$base->getError());
        }
        return $resp;
    }

    public static function listar($parametro="")
    {
        $arreglo = array();
        $base=new BaseDatos();
        $sql="SELECT * FROM producto ";
        if ($parametro!="") {
            $sql.='WHERE '.$parametro;
        }
        $res = $base->Ejecutar($sql);
        if ($res>-1) {
            if ($res>0) {
                while ($row = $base->Registro()) {
                    
                    $obj->setear($row['idproducto'], $row['pronombre'], $row['prodetalle'], $row['procantstock']);
                    array_push($arreglo, $obj);
                }
            }
        } else {
            $this->setMensajeOperacion("producto->listar: ".$base->getError());
        }

        return $arreglo;
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

    /**
     * Get the value of idproducto
     */ 
    public function getID()
    {
        return $this->idproducto;
    }

    /**
     * Set the value of idproducto
     *
     * @return  self
     */ 
    public function setID($idproducto)
    {
        $this->idproducto = $idproducto;

        return $this;
    }

    /**
     * Get the value of pronombre
     */ 
    public function getPronombre()
    {
        return $this->pronombre;
    }

    /**
     * Set the value of pronombre
     *
     * @return  self
     */ 
    public function setPronombre($pronombre)
    {
        $this->pronombre = $pronombre;

        return $this;
    }

    /**
     * Get the value of prodetalle
     */ 
    public function getProdetalle()
    {
        return $this->prodetalle;
    }

    /**
     * Set the value of prodetalle
     *
     * @return  self
     */ 
    public function setProdetalle($prodetalle)
    {
        $this->prodetalle = $prodetalle;

        return $this;
    }

    /**
     * Get the value of procantstock
     */ 
    public function getProcantstock()
    {
        return $this->procantstock;
    }

    /**
     * Set the value of procantstock
     *
     * @return  self
     */ 
    public function setProcantstock($procantstock)
    {
        $this->procantstock = $procantstock;

        return $this;
    }
}
