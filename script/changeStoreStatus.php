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

$objTienda = new Tienda();
$tienda = $objTienda->getStoreStatus();

if (trim($tienda['estado'])=='CERRADO'){
    $objTienda->updateStoreStatus('ABIERTO');
    /*header('location: ../tienda');*/
    ?>

    <script>
        window.location = '../tienda';
    </script>
    <?php
}
if (trim($tienda['estado'])=='ABIERTO'){
    $objTienda->updateStoreStatus('CERRADO');
    /*header('location: ../tienda');*/
    ?>

    <script>
        window.location = '../tienda';
    </script>
    <?php
}

