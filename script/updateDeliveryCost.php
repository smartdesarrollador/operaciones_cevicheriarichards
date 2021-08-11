<?php
session_start();
error_reporting(0);
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
include '../model/Tienda.php';

if (isset($_POST['costoEnvio'])){
    $nuevoCostoEnvio = trim($_POST['costoEnvio']);


    $objTienda = new Tienda();

    $tienda = $objTienda->updateCostoEnvio($nuevoCostoEnvio);

    header('location: ../tienda?code=success');

}else{
    echo "No tiene autorizacion para ver esta pagina";
}


