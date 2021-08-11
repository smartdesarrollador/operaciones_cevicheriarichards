<?php
session_start();
if (isset($_SESSION["current_email"])) {

} else {
    header('HTTP/1.1 301 Moved Permanently');
    header('location: ./');
    exit();
}

if ($_SESSION['current_rol'] == 'admin') {

} else {
    echo "No tienes Permisos para acceder a este lugar";
    exit();
}



include '../model/Clientes.php';
include '../model/Consumo.php';
$objCliente = new Clientes();
$objConsumo =  new Consumo();

$idCliente = $_POST['idCliente'];
$montoConsumo = $_POST['montoConsumo'];

$cliente = $objCliente->getClienteById($idCliente);


if ($montoConsumo ==0){
    $_SESSION['mensaje'] = 'error';

    $ir = $_SERVER['HTTP_REFERER'];
    header("location:$ir");
    exit();
}


if ($cliente['saldoBilletera']<$montoConsumo){
    $_SESSION['mensaje'] = 'error';

    $ir = $_SERVER['HTTP_REFERER'];
    header("location:$ir");
    exit();

}


$affectedRows = $objCliente->reducirSaldoCliente($idCliente, $montoConsumo);
$objConsumo->addNewConsumo($idCliente,$montoConsumo);

if ($affectedRows >0){
    $_SESSION['mensaje'] = 'correcto';

    $ir = $_SERVER['HTTP_REFERER'];
    header("location:$ir");


};

