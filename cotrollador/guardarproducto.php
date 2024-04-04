<?php

include "../model/proDAO.php";
$data=json_decode(file_get_contents('php://input'), true);
if(isset($data['nombre'])){
    $pro=new ProductoDAO();
    $pro->insertar($data['nombre'],$data['descripcion']);
    header("location:../view/index.html");
    echo "datos guardados exitoxa mente";
    exit();
}else{
    echo "variables indefinidas";
}