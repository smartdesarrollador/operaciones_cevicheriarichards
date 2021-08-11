<?php

include '../../model/Delivery.php';
$objDelivery = new Delivery();

$id = $_POST['idDelivery'];
$precio = $_POST['precioDelivery'];


echo  $objDelivery->cambiarCostoEnvioDistrito($id, $precio);

