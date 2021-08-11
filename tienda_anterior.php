<?php
session_start();
$page = 'store';
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

include 'model/Tienda.php';

$objTienda = new Tienda();
$tienda = $objTienda->getStoreStatus();


$estado = $tienda['estado'];
$costoDelivery = trim($objTienda->getCostoEnvio()['costoDelivery']);

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>.::Dashboard::.</title>
    <?php include 'layout/library.php' ?>


    <style>
        .switch label {
            font-weight: 900;
        }
    </style>
</head>
<body class="">
<?php include 'layout/userNavBar.php' ?>
<div class="container">
    <div class="row">
        <div class="col l4 s12 m4 xl4 push-l4 push-l4 push-xl4 push-xl4 push-m4 pull-m4 z-depth-5 "
             style="border-radius: 5px; border: 3px solid black;margin-top: 30px">
            <h5 class="center-align">Estado de la Tienda</h5>

            <!-- Switch -->
            <?php if ($estado == 'CERRADO') { ?>
                <div class="switch center-align " style="margin-top: 100px;margin-bottom: 100px">
                    <label>
                        CERRADO
                        <input onclick="return confirm('Estas Seguro?');" id="chkTiendaStatus" type="checkbox" class="">
                        <span class="lever"></span>
                        ABIERTO
                    </label>
                </div>
            <?php } ?>
            <?php if ($estado == 'ABIERTO') { ?>
                <div class="switch center-align " style="margin-top: 100px;margin-bottom: 100px">
                    <label>
                        CERRADO
                        <input onclick="return confirm('Estas Seguro?');" checked id="chkTiendaStatus" type="checkbox"
                               class="">
                        <span class="lever"></span>
                        ABIERTO
                    </label>
                </div>
            <?php } ?>
        </div>
    </div>

    <div class="row">
        <div class="col l4 s12 m4 xl4 push-l4 push-l4 push-xl4 push-xl4 push-m4 pull-m4 z-depth-5  "
             style="border-radius: 5px; border: 3px solid black;margin-top: 30px">
            <h5 class="center-align">Costo de Delivery</h5>

            <form action="script/updateDeliveryCost.php" method="post">


                <div class="row">
                    <div class="col s12 m12 xl12 l12 center-align">
                        S/
                        <div class="input-field inline ">

                            <input name="costoEnvio" value="<?php echo $costoDelivery; ?>"
                                   onkeypress="return solonumeros()" required
                                   id="first_name" type="number" class="validate center-align">

                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col l12 s12 xl12 m12 center-align">
                        <button type="submit" class="waves-effect waves-light btn-large black"
                                style="margin-bottom: 20px"><i
                                    class="material-icons right">save</i>Guardar
                        </button>

                    </div>
                </div>

            </form>

        </div>
    </div>
</div>
<?php include 'layout/userFooter.php' ?>
<script>
    $('#chkTiendaStatus').change(function () {
        setTimeout(cambiarEstado, 300);

    });

    function cambiarEstado() {
        window.location = 'script/changeStoreStatus.php';
    }

    function solonumeros(e) {
        var keynum = window.event ? window.event.keyCode : e.which;
        if ((keynum == 8) || (keynum == 46))
            return true;

        return /\d/.test(String.fromCharCode(keynum));
    };

</script>

<?php
if (isset($_GET['code'])) {
    if ($_GET['code'] == 'success') { ?>
        <script>M.toast({html: 'Correcto! Se ha Actualizado la Tienda!'})</script>
        <?php
    }
}
?>
</body>
</html>
