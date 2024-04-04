<?php
include "../model/conexion/conexion.php";
include "../config/config.php";

class ProductoDAO
{
  private $conn;
  public function __construct()
  {
    $this->conn = new Conexion(DB_HOST, port, DB_NAME, DB_USER, DB_PASS);
  }

  public  function traer_datos()
  {
    $conexion = $this->conn->abrir_conexion();
    if (is_object($conexion)) {
      $consulta = $conexion->prepare("SELECT * FROM producto");
      $consulta->execute();
      $resultado = $consulta->fetchALL(PDO::FETCH_ASSOC);
      return $resultado;
    } else {
      return $conexion;
    };
  }


  public  function eliminar($key)
  {
    $conexion = $this->conn->abrir_conexion();
    $conexion = $conexion->prepare("DELETE FROM producto WHERE id=:id ");
    $ar = array(":id" => $key);
    $conexion->execute($ar);
  }

  public  function insertar($nombre, $descripcion)
  {
    $conexion = $this->conn->abrir_conexion();
    $conexion = $conexion->prepare("INSERT INTO producto(nombre,descripcion)VALUES(:nombre,:descripcion) ");
    $ar = array(
      ":nombre" => $nombre,
      ":descripcion" => $descripcion
    );
    $conexion->execute($ar);
  }


  public function actualizar($nombre, $descripcion, $id)
  {
    $conexion = $this->conn->abrir_conexion();
    $conexion = $conexion->prepare("UPDATE producto SET nombre=:nombre,descripcion=:descripcion WHERE id=:id");
    $ar = array(
      ":nombre" => $nombre,
      ":descripcion" => $descripcion,
      ":id" => $id
    );
    $conexion->execute($ar);
  }




  public  function cerrarconexion()
  {
    $this->conn = null;
  }
}
