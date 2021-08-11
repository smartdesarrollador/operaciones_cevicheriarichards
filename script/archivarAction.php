<?php
session_start();
error_reporting(0);
if (isset($_SESSION["current_email"]) && $_SESSION["current_email"] != '') {

} else {
    echo "Usuario no Autorizado";
    exit();
}

if ($_SESSION['current_rol'] == 'admin') {

} else {
    echo "No tienes Permisos para acceder a este lugar";
    exit();
}
if (isset($_GET['id']) && $_GET['id'] != '' && isset($_GET['status']) && $_GET['status'] != '') {
} else {
    echo "No tienes Permisos para acceder a este lugar";
    exit();
}

include '../model/Producto.php';
$objProducto = new Producto();
$id = trim($_GET['id']);


if (trim($_GET['status']) == 0) {

    $objProducto->changeStatusProduct($id, 'ACTIVO');
    header('location: ../productos_archivados?code=restored');

} elseif (trim($_GET['status']) == 1) {

    $objProducto->changeStatusProduct($id, 'ARCHIVADO');
    header('location: ../productos?code=archived');

} else {
    echo json_encode('error');
}
