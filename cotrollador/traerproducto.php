<?php
include "../model/proDAO.php";
$pro=new ProductoDAO();
if(is_array($pro->traer_datos())){
    echo json_encode($pro->traer_datos());
    $pro->cerrarconexion();
}else{
    echo $pro->traer_datos();
};
