<?php
set_time_limit(1200);
include '../model/Tienda.php';
include '../model/Pedido.php';
include '../model/SmsLog.php';
require '../vendor/autoload.php';
use Aws\Exception\AwsException;
use Aws\Sns\SnsClient;

$objTienda = new Tienda();
$objPedido = new Pedido();
$objSmsLog = new SmsLog();

$tienda = $objTienda->getStoreStatus();


$estado = $tienda['estado'];
if ($estado == 'CERRADO') {
    exit();
};
$listaPedido = $objPedido->getAllPedidos();

foreach ($listaPedido as $pedido) {
    if ($pedido['idEstado'] == 2 && $pedido['feedBackEnviado'] == 'false') {

        date_default_timezone_set('America/Lima');

        $DBtimeToTimeStamp = $pedido['dateTime'];
        $actualTime = time();
        /*
         * 30minutos
         * $requiredTime = $DBtimeToTimeStamp + 1800;*/


        /*5 min
         * $requiredTime = $DBtimeToTimeStamp + 300;*/


         $requiredTime = $DBtimeToTimeStamp + 1200;



        if ($actualTime > $requiredTime) {


            $token = trim(uniqid());

            $objPedido->changeFeedBackStatus($pedido['idPedido'], 'true', $token);
            $telefonoDestino = trim('+51'.$pedido['pedidoTelefono']);

            $mensaje = 'Hola, ¿cómo te fue con tu pedido? por favor ayúdanos a seguir mejorando';
            $url = 'https://cevicheriarichards.com/r.php?i=' . $pedido['idPedido'] . '&t=' . $token;
            $mensajeCompleto = $mensaje . ' ' . $url;

            $SnSclient = new SnsClient([
                'profile' => 'default',
                'region' => 'us-east-1',
                'version' => 'latest'
            ]);


            try {
                $result = $SnSclient->publish([
                    'Message' => $mensajeCompleto,
                    'PhoneNumber' => $telefonoDestino,
                ]);

                $objSmsLog->addNewSmsLog($telefonoDestino, $url);

                echo $telefonoDestino.'<br>';
            echo $mensajeCompleto;

                print_r($result) ;


            } catch (AwsException $e) {
                print_r($e);
                error_log($e->getMessage());
            }







        }
    }
}
