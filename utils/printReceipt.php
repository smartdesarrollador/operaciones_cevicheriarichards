<?php
session_start();
if (isset($_SESSION["current_email"]) && $_SESSION["current_email"] != '') {
} else {
    header('HTTP/1.1 301 Moved Permanently');
    header('location: ./');
    exit();
}
if ($_SESSION['current_rol'] == 'admin') {

} else {
    header('HTTP/1.1 301 Moved Permanently');
    header('location: ./');
    exit();
}
include '../model/Pedido.php';
$objPedido = new Pedido();
include '../model/Helper.php';


$helper = new Helper();
include '../model/Tienda.php';

$objTienda = new Tienda();

$costoDelivery = trim($objTienda->getCostoEnvio()['costoDelivery']);

$idPedido = $_GET['order'];
$pedido = $objPedido->getPedidoByID(trim($idPedido));
$items = $objPedido->getPedidosItemsByidPedido(trim($idPedido));


?>
<!doctype html>
<html lang="es">
<head><meta charset="gb18030">
    
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Pedido</title>
    <style>
        * {
            font-weight: bolder;
        }

        #invoice-POS {
            box-shadow: 0 0 1in -0.25in rgba(0, 0, 0, 0.5);
            padding: 2mm;

            width: 44mm;
            background: #FFF;
        }

        #invoice-POS ::selection {
            background: #f31544;
            color: #FFF;
        }

        #invoice-POS ::moz-selection {
            background: #f31544;
            color: #FFF;
        }

        #invoice-POS h1 {
            font-size: 1.5em;
            color: #222;
        }

        #invoice-POS h2 {
            font-size: 1em;
            margin: 0;
        }

        #invoice-POS h3 {
            font-size: 1.3em;
            font-weight: 300;
            line-height: 2em;
        }

        #invoice-POS p {
            font-size: .6em;
            color: #000000;
            line-height: 1.2em;
        }

        #invoice-POS #top, #invoice-POS #mid, #invoice-POS #bot {
            /* Targets all id with 'col-' */
            border-bottom: 1px solid #EEE;
        }

        #invoice-POS #top {
            min-height: 100px;
        }

        #invoice-POS #mid {
            min-height: 80px;
        }

        #invoice-POS #bot {
            min-height: 50px;
        }

        #invoice-POS #top .logo {
            height: 60px;
            width: 60px;
            background: url(http://michaeltruong.ca/images/logo1.png) no-repeat;
            background-size: 60px 60px;
        }

        #invoice-POS .clientlogo {
            float: left;
            height: 60px;
            width: 60px;
            background: url(http://michaeltruong.ca/images/client.jpg) no-repeat;
            background-size: 60px 60px;
            border-radius: 50px;
        }

        #invoice-POS .info {
            display: block;
            margin-left: 0;
        }

        #invoice-POS .title p {
            text-align: right;
        }

        #invoice-POS table {
            width: 100%;
            border-collapse: collapse;
        }

        #invoice-POS .tabletitle {
            font-size: .6em;
            background: #EEE;
        }

        #invoice-POS .tableitem {
            padding: 0;
            margin: 0;
        }

        #invoice-POS .service {
            border-bottom: 1px solid #EEE;
        }

        #invoice-POS .item {
            width: 24mm;
        }

        #invoice-POS .itemtext {
            font-size: .5em;
            margin: 0;
        }

        #invoice-POS #legalcopy {
            margin-top: 0;
        }

        @media print {
            .buttons {
                display: none;
            }
        }
    </style>
</head>
<body>

<div id="invoice-POS">
    <div id="mid">
        <div class="info">
            <h2 style="text-align: center;margin-top: 0;margin-bottom: 0">Richards - Delivery</h2>
            <h6 style="margin: 5px 0;">
                Pedido Nro: #<?php echo str_pad($pedido['idPedido'], 8, "0", STR_PAD_LEFT); ?></br>
                Hora y fecha: <strong><?php echo $pedido['horaPedido'] ?>( <?php echo $pedido['fechaPedido'] ?>
                    )</strong></br>
                Dirección: <strong><?php echo $pedido['direccionPedido'] ?></strong></br>
                <?php if ($pedido['documento'] == 'factura') { ?>
                Ruc: <strong><?php echo $pedido['ruc'] ?></strong></br>
                <?php } ?>
                Nombres: <strong><?php echo $pedido['nombre'] ?></strong></br>
                Apellidos: <strong><?php echo $pedido['apellido'] ?></strong></br>
                DNI: <strong><?php echo $pedido['DNI'] ?></strong></br>
                Celular: <strong><?php echo $pedido['pedidoTelefono'] ?></strong></br>
                Correo: <strong><?php echo $pedido['email'] ?></strong></br>
                Fec Nacimiento: <strong><?php echo $pedido['fechaNacimiento'] ?></strong></br>
                Tarjeta: <strong><?php echo $pedido['brand'] ?></strong></br>
            </h6>
        </div>
    </div><!--End Invoice Mid-->

    <div id="bot">

        <div id="table">
            <table>
                <tr class="tabletitle">
                    <td class="item"><h2 style="padding: 0;margin: 0">Producto</h2></td>
                    <td class="Hours"><h2 style="padding: 0;margin: 0">Cantidad</h2></td>
                    <td class="Rate"><h2 style="padding: 0;margin: 0">SubTotal</h2></td>
                </tr>

                <?php foreach ($items as $item) { ?>
                    <tr class="service">
                        <td class="tableitem"><h6 class="itemtext">
                                <?php echo '<strong>' . $item['nombreProducto'] . '</strong>';

                                if ($item['item_descripcion'] != '') {
                                    echo ':<br><strong>' . strtolower($item['item_descripcion']) . '</strong>';
                                }
                                if ($item['codigoProducto'] == '252' || $item['codigoProducto'] == '253' || $item['codigoProducto'] == '254') {
                                    echo ':<br><strong>(Incluir Chicha)</strong>';
                                }
                                ?>
                            </h6></td>
                        <td class="tableitem"><h6 class="itemtext"><?php echo $item['cantidad'] ?></h6></td>
                        <td class="tableitem"><h6 class="itemtext">S/. <?php echo $item['precioProducto'] ?></h6></td>
                    </tr>

                <?php } ?>


                <tr class="tabletitle">
                    <td></td>
                    <td class="Rate"><h2>Delivery</h2></td>
                    <td class="payment"><h2>S/. <?php echo $costoDelivery ?></h2></td>
                </tr>

                <tr class="tabletitle">
                    <td></td>
                    <td class="Rate"><h2>Total</h2></td>
                    <td class="payment"><h2>S/. <?php echo $pedido['precioTotal'] ?></h2></td>
                </tr>

            </table>
        </div><!--End Table-->

        <div id="legalcopy">
            <p class="legal" style="margin: 0 !important;">
                <?php echo $pedido['pedidoObservaciones'] ?>
            </p>
        </div>


    </div><!--End InvoiceBot-->
</div><!--End Invoice-->
<div class="buttons" style="text-align: center">
    <button style="padding: 30px;font-size: 25px" onclick="window.print()">IMPRIMIR</button>
</div>

</body>
</html>
