<?php
session_start();
error_reporting(0);
include '../model/Pedido.php';
$objPedido = new Pedido();

if (isset($_SESSION["current_email"]) || $_SESSION["current_email"] != '') {
} else {
    echo 'error';
    exit();
}
if (!isset($_POST['idEstado'], $_POST['idPedido'])) {
    echo 'error';
    exit();
} else {
    $idEstado = trim($_POST['idEstado']);
    $idPedido = trim($_POST['idPedido']);
 echo $objPedido->updateOrderStatus($idEstado,$idPedido);

}








