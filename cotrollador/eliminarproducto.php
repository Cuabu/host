<?php
include "../model/proDAO.php";
$data = json_decode(file_get_contents('php://input'), true);
if (isset($data['id'])) {
    $pro = new ProductoDAO();
    $pro->eliminar($data['id']);


    exit();
} else {
    echo "variables indefinidas";
}
