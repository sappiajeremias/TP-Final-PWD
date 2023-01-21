<?php
class BaseDatos extends PDO {
private $engine;
private $host;
private $database;
private $user;
private $pass;
private $debug;
private $conec;
private $indice;
private $resultado;

public function __construct() {
    $this->engine = 'mysql';
    //$this->host = '127.0.0.1:3306';
    $this->host = 'localhost';
    $this->database = 'bdcarritocompras'; // MODIFICAR POR CADA TP
    $this->user = 'root';
    $this->pass = '';
    $this->debug = true;
    $this->error = "";
    $this->sql = "";
    $this->indice = 0;

    $dns = $this->engine . ':dbname=' . $this->database . ";host=" . $this->host;
    try {
        parent::__construct($dns, $this->user, $this->pass, array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8'));
        $this->conec = true;
    } catch (PDOException $error) {
        $this->sql = $error->getMessage();
        $this->conec = false;
    }
}
public function Iniciar() {
    /* Inicia la coneccion con el Servidor y la  Base Datos Mysql.
     * Retorna true si la coneccion con el servidor se pudo establecer y false en caso contrario
     * @return boolean
     */
    return $this->getConec();
}

public function getConec() {
    return $this->conec;
}

public function setDebug($debug) {
    $this->debug = $debug;
}
public function getDebug() {
    return $this->debug;
}

private function setIndice($valor) {
    $this->indice = $valor;
}
private function getIndice() {
    return $this->indice;
}

private function setResultado($valor) {
    $this->resultado = $valor;
}
private function getResultado() {
    return $this->resultado;
}

public function setError($error) {
    // Funcion que setea la variable instancia error
    $this->error = $error;
}
public function getError() {
    /* Funcion que retorna una cadena con descripcion del ultimo error seteado
     * @return 
     */
    return "\n" . $this->error;
}


public function setSQL($error) {
    //
    return "\n" . $this->sql = $error;
}

    
public function getSQL() {
    // Funcion que retorna una cadena con el ultimo sql seteado
    return "\n" . $this->sql;
}

public function Ejecutar($sql) {
    
    $this->setError("");
    $this->setSQL($sql);
    if (stristr($sql, "insert")) { // se desea NSERT ? 
        $resp =  $this->EjecutarInsert($sql);
    }
    // se desea UPDATE o DELETE ? 
    if (stristr($sql, "update") or stristr($sql, "delete")) {
        
        $resp =  $this->EjecutarDeleteUpdate($sql);
    }

    // se desea ejecutar un select
    if (stristr($sql, "select")) {
        $resp =  $this->EjecutarSelect($sql);
    }
  
    return $resp;
}

private function EjecutarInsert($sql) {
    /* Si se inserta en una tabla que tiene una columna autoincrement 
     * se retorna el id con el que se inserto el registro
     * caso contrario se retorna -1
     */
    $resultado = parent::query($sql);
    if (!$resultado) {
        $this->analizarDebug();
        $id = 0;
    } else {
        $id =  $this->lastInsertId();
        if ($id == 0) {
            $id = -1;
        }
    }
    return $id;
}

private function EjecutarDeleteUpdate($sql) {
    /* Devuelve la cantidad de filas afectadas por la ejecucion SQL. 
     * Si el valor es <0 no se pudo realizar la opercion
     * @return integer
     */
    $cantFilas = -1;
    $resultado = parent::query($sql);
    if (!$resultado) {
        $this->analizarDebug();
    } else {
        $cantFilas =  $resultado->rowCount();
    }
    return $cantFilas ;
}


private function EjecutarSelect($sql) {
    /* Retorna cada uno de los registros de una consulta select
     * @return integer
     */
    $cant = -1;
    $resultado = parent::query($sql);
    if (!$resultado) {
        $this->analizarDebug();
    } else {
        $arregloResult = $resultado->fetchAll();
        $cant = count($arregloResult);
        $this->setIndice(0);
        $this->setResultado($arregloResult);
    }
    return $cant;
}
    
public function Registro() {
    /* Devuelve un registro retornado por la ejecucion de una consulta
     * el puntero se despleza al siguiente registro de la consulta
     * @return array
     */
    $filaActual = false;
    $indiceActual = $this->getIndice();
    if ($indiceActual >= 0) {
        $filas = $this->getResultado();
        if ($indiceActual < count($filas)) {
            $filaActual =  $filas[$indiceActual];

            $indiceActual++;
            $this->setIndice($indiceActual);
        } else {
            $this->setIndice(-1);
        }
    }
    return $filaActual;
}

private function analizarDebug() {
    // Esta funcion si esta seteado la variable instancia $this->debug visualiza el debug
    $error = $this->errorInfo();
    $this->setError($error);
    if ($this->getDebug()) {
        echo "<pre>";
        print_r($error);
        echo "</pre>";
    }
}
}

?>