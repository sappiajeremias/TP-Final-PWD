<?php

class rol extends BaseDatos
{

    private $idrol;
    private $roldescripcion;
    private $mensajeOperacion;

    public function __construct()
    {
        parent::__construct();
        $this->idrol = "";
        $this->roldescripcion = "";
        $this->mensajeOperacion = "";
    }

    public function setear($idRol, $rolDescripcion)
    {
        $this->setID($idRol);
        $this->setRolDescripcion($rolDescripcion);
    }

    //MÉTODOS PROPIOS DE LA CLASE

    public function cargar()
    {
        $resp = false;
        $sql = "SELECT * FROM rol WHERE idrol = " . $this->getID();
        if ($this->Iniciar()) {
            $res = $this->Ejecutar($sql);
            if ($res > -1) {
                if ($res > 0) {
                    $row = $this->Registro();
                    $this->setear($row['idrol'], $row['roldescripcion']);
                }
            }
        } else {
            $this->setMensajeOperacion("rol->cargar: " . $this->getError());
        }
        return $resp;
    }

    public function insertar()
    {
        $resp = false;
        // Si lleva ID Autoincrement, la consulta SQL no lleva dicho ID
        $sql = "INSERT INTO rol(roldescripcion) 
            VALUES('"
            . $this->getRolDescripcion() . "'
        );";
        if ($this->Iniciar()) {
            if ($esteid = $this->Ejecutar($sql)) {
                // Si se usa ID autoincrement, descomentar lo siguiente:
                $this->setID($esteid);
                $resp = true;
            } else {
                $this->setMensajeOperacion("rol->insertar: " . $this->getError());
            }
        } else {
            $this->setMensajeOperacion("rol->insertar: " . $this->getError());
        }
        return $resp;
    }

    public function modificar()
    {
        $resp = false;
        $sql = "UPDATE rol 
        SET roldescripcion='" . $this->getRolDescripcion() .
            "' WHERE idrol='" . $this->getID() . "'";
        if ($this->Iniciar()) {
            if ($this->Ejecutar($sql)) {
                $resp = true;
            } else {
                $this->setMensajeOperacion("rol->modificar: " . $this->getError());
            }
        } else {
            $this->setMensajeOperacion("rol->modificar: " . $this->getError());
        }
        return $resp;
    }

    public function eliminar()
    {
        $resp = false;
        $sql = "DELETE FROM rol WHERE idrol=" . $this->getID();
        if ($this->Iniciar()) {
            if ($this->Ejecutar($sql)) {
                return true;
            } else {
                $this->setMensajeOperacion("rol->eliminar: " . $this->getError());
            }
        } else {
            $this->setMensajeOperacion("rol->eliminar: " . $this->getError());
        }
        return $resp;
    }

    public function listar($parametro = "")
    {
        $arreglo = array();
        $sql = "SELECT * FROM rol ";
        if ($parametro != "") {
            $sql .= 'WHERE ' . $parametro;
        }
        if ($this->Iniciar()) {
            $res = $this->Ejecutar($sql);
            if ($res > -1) {
                if ($res > 0) {
                    while ($row = $this->Registro()) {

                        $obj = new rol();
                        $obj->setear($row['idrol'], $row['roldescripcion']);
                        array_push($arreglo, $obj);
                    }
                }
            } else {
                $this->setMensajeOperacion("rol->listar: " . $this->getError());
            }
        }

        return $arreglo;
    }


    //MÉTODOS GET
    public function getID()
    {
        return $this->idrol;
    }

    public function getRolDescripcion()
    {
        return $this->roldescripcion;
    }

    public function getMensajeOperacion()
    {
        return $this->mensajeOperacion;
    }

    //MÉTODOS SET
    public function setID($newIdRol)
    {
        $this->idrol = $newIdRol;
        return $this;
    }

    public function setRolDescripcion($newRolDescripcion)
    {
        $this->roldescripcion = $newRolDescripcion;
        return $this;
    }
    public function setMensajeOperacion($newMensajeOperacion)
    {
        $this->mensajeOperacion = $newMensajeOperacion;
        return $this;
    }
}
