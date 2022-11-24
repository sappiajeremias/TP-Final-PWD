<?php

class compra extends BaseDatos
{

    private $idcompra;
    private $cofecha; //TIMESTAMP
    private $objusuario;
    private $mensajeoperacion;

    public function __construct()
    {
        parent::__construct();
        $this->idcompra = "";
        $this->cofecha = date('Y-m-d H:i:s');
        $this->objusuario = "";
        $this->mensajeoperacion = "";
    }

    public function setear($idcompra, $cofecha, $objusuario)
    {
        $this->setID($idcompra);
        $this->setCoFecha($cofecha);
        $this->setObjUsuario($objusuario);
    }

    public function setearSinID($cofecha, $objusuario){
        $this->setCoFecha($cofecha);
        $this->setObjUsuario($objusuario);
    }


    //MÉTODOS PROPIOS DE LA CLASE

    public function cargar()
    {
        $resp = false;
        $sql = "SELECT * FROM compra WHERE idcompra = " . $this->getID();
        if ($this->Iniciar()) {
            $res = $this->Ejecutar($sql);
            if ($res > -1) {
                if ($res > 0) {
                    $row = $this->Registro();

                    $objUsuario = new usuario();
                    $objUsuario->setID($row['idusuario']);
                    $objUsuario->cargar();

                    $this->setear($row['idcompra'], $row['cofecha'], $objUsuario);
                }
            }
        } else {
            $this->setMensajeOperacion("compra->listar: " . $this->getError());
        }
        return $resp;
    }

    public function insertar()
    {
        //Fecha ini poner fecha actual
        //Setear fecha fin cuando el admin apruebe la compra (fecha)
        $resp = false;
        // Si lleva ID Autoincrement, la consulta SQL no lleva dicho ID
        $sql = "INSERT INTO compra(cofecha, idusuario) 
            VALUES('"
            . $this->getCofecha() . "', '"
            . $this->getObjUsuario()->getID() . "'
        );";
        if ($this->Iniciar()) {
            if ($esteid = $this->Ejecutar($sql)) {
                // Si se usa ID autoincrement, descomentar lo siguiente:
                $this->setID($esteid);
                $resp = true;
            } else {
                $this->setMensajeOperacion("compra->insertar: " . $this->getError());
            }
        } else {
            $this->setMensajeOperacion("compra->insertar: " . $this->getError());
        }
        return $resp;
    }

    public function modificar()
    {
        $resp = false;
        $sql = "UPDATE compra 
        SET cofecha='" . $this->getCofecha()
            . "', idusuario='" . $this->getObjUsuario()->getID()
            . "' WHERE idcompra='" . $this->getID() . "'";
        if ($this->Iniciar()) {
            if ($this->Ejecutar($sql)) {
                $resp = true;
            } else {
                $this->setMensajeOperacion("compra->modificar: " . $this->getError());
            }
        } else {
            $this->setMensajeOperacion("compra->modificar: " . $this->getError());
        }
        return $resp;
    }

    public function eliminar()
    {
        $resp = false;
        $sql = "DELETE FROM compra WHERE idcompra=" . $this->getID();
        if ($this->Iniciar()) {
            if ($this->Ejecutar($sql)) {
                return true;
            } else {
                $this->setMensajeOperacion("compra->eliminar: " . $this->getError());
            }
        } else {
            $this->setMensajeOperacion("compra->eliminar: " . $this->getError());
        }
        return $resp;
    }

    public function listar($parametro = "")
    {
        $arreglo = array();
        $sql = "SELECT * FROM compra ";
        if ($parametro != "") {
            $sql .= 'WHERE ' . $parametro;
        }
        $res = $this->Ejecutar($sql);
        if ($res > -1) {
            if ($res > 0) {
                while ($row = $this->Registro()) {
                    $obj = new compra();

                    $objUsuario = new usuario();
                    $objUsuario->setID($row['idusuario']);
                    $objUsuario->cargar();

                    $obj->setear($row['idcompra'], $row['cofecha'], $objUsuario);
                    array_push($arreglo, $obj);
                }
            }
        } else {
            $this->setMensajeOperacion("compra->listar: " . $this->getError());
        }

        return $arreglo;
    }




    /**
     * Get the value of idcompra
     */
    public function getID()
    {
        return $this->idcompra;
    }

    /**
     * Set the value of idcompra
     *
     * @return  self
     */
    public function setID($idcompra)
    {
        $this->idcompra = $idcompra;

        return $this;
    }

    /**
     * Get the value of cofecha
     */
    public function getCofecha()
    {
        return $this->cofecha;
    }

    /**
     * Set the value of cofecha
     *
     * @return  self
     */
    public function setCofecha($cofecha)
    {
        $this->cofecha = $cofecha;

        return $this;
    }

    /**
     * Get the value of idusuario
     */
    public function getObjUsuario()
    {
        return $this->objusuario;
    }

    /**
     * Set the value of idusuario
     *
     * @return  self
     */
    public function setObjUsuario($newObjetoUsuario)
    {
        $this->objusuario = $newObjetoUsuario;

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
