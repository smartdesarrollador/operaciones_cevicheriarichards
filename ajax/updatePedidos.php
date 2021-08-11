<?php
include '../model/Pedido.php';
$objPedido = new Pedido();

date_default_timezone_set('America/Lima');
$actualDate = date('Ymd');

$pedidos = $objPedido->getCountOfPEdidos();

echo $pedidos['total'];




