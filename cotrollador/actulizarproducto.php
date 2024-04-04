<?php
include "../model/proDAO.php";
$data = json_decode(file_get_contents('php://input'), true);
if (isset($data['nombre'])) {
    $pro = new ProductoDAO();
    $pro->actualizar($data['nombre'], $data['descripcion'], $data['id']);
    header("location:../view/index.html");
    echo "datos guardados exitoxa mente";
    exit();
} else {
    echo "variables indefinidas";
}
