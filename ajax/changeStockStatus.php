<?php
session_start();
error_reporting(0);
include '../model/Producto.php';
$objProducto = new Producto();


if (isset($_SESSION["current_email"]) && $_SESSION["current_email"] != '' ) {

} else {
    echo "Usuario no Autorizado";
    exit();
}

if ($_SESSION['current_rol'] =='admin') {

}else{
    echo "No tienes Permisos para acceder a este lugar";
    exit();
}
$id = trim($_POST['id']);
$stock = trim($_POST['stock']);

$stock = $objProducto->updateStockStatus($id,$stock);
echo $stock;
