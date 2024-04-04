<?php

class Conexion {
    private $conexion;
    private $host;
    private $port;
    private $db;
    private $user;
    private $password;

    public function __construct($host, $port, $db, $user, $password) {
        $this->host = $host;
        $this->port = $port;
        $this->db = $db;
        $this->user = $user;
        $this->password = $password;
    }

    public function abrir_conexion() {
        try {
            $dbh = new PDO("mysql:host=" . $this->host . ";port=" . $this->port . ";dbname=" . $this->db, $this->user, $this->password);
            return $dbh;
        } catch (PDOException $e) {
            return "Error de conexión: " . $e->getMessage();
            exit;
        }
    }
    public  function cerrar_conexion(){
        $this->conexion=null;
    }
}

?>
