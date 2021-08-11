<?php
include_once '../../model/Pedido.php';
header('Content-Type: application/json');
$objPedido = new Pedido();
$lista = $objPedido->reporteVentasUltimos6Meses();

$response = json_encode(array_slice($lista, -12, 12));
echo $response;
