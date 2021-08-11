<?php
session_start();
error_reporting(0);
$page = 'giftCards';
if (isset($_SESSION["current_email"]) && $_SESSION["current_email"] != '') {

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
include "model/Clientes.php";
include "model/Helper.php";

$objCliente = new Clientes();
$helper = new Helper();

$idClienteEncriptado = $_GET['token'];

$idCliente = $helper->my_simple_crypt($idClienteEncriptado, 'd');

$cliente = $objCliente->getClienteById($idCliente);
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

        .main-container {
            margin-top: 20px;
        }
    </style>
</head>
<body class="">
<?php include 'layout/userNavBar.php' ?>
<div class="container main-container">
    <!--<div class="row">
        <div class="col l4 push-l4 pull-l4 s12 center-align animated fadeIn"
             style="border-radius:5px;border: 2px solid black">
            <div class="row">
                <h6>Buscar por Correo</h6>
                <div class="input-field col s12">
                    <input id="caja_busqueda" type="text" class="validate">
                    <label for="caja_busqueda"><i class="material-icons">search</i></label>
                </div>
                <button style="margin-bottom: 10px" class="btn black white-text">Buscar</button>
            </div>

        </div>
    </div>-->
    <div class="row">
        <div class="col s12 m6" style="padding: 20px">
            <div class="card ">

                <div class="center-align">
                    <img style="max-width: 200px" src="img/icons/usuario.png">
                </div>
                <div class="card-content center-align">

                    <table>
                        <tbody>
                        <tr>
                            <th>Nombre</th>
                            <td><?php echo $cliente['nombre'] ?></td>
                        </tr>
                        <tr>
                            <th>Apellido</th>
                            <td><?php echo $cliente['apellido'] ?></td>
                        </tr>
                        <tr>
                            <th>Correo</th>
                            <td><?php echo $cliente['email'] ?></td>
                        </tr>
                        <tr>
                            <th>DNI</th>
                            <td><?php echo $cliente['DNI'] ?></td>
                        </tr>
                        <tr>
                            <th>Celular</th>
                            <td><?php echo $cliente['celular'] ?></td>
                        </tr>
                        <tr>
                            <th>Puntos</th>
                            <td><?php echo $cliente['puntos'] ?></td>
                        </tr>
                        <tr>
                            <th>Dirección</th>
                            <td><?php echo $cliente['direccion'] ?></td>
                        </tr>

                        </tbody>
                    </table>
                    <h4>saldo actual: S/. <?php echo $cliente['saldoBilletera'] ?></h4>
                </div>
            </div>
        </div>
        <div class="col s12 m6">
            <div class="row">

                <h5 class="center-align">Agregar Consumo</h5>

                <form
                        id="consumoCliente"
                        action="script/consumoCliente.php"
                        method="post">


                    <div class="row">
                        <div class="col s12 m12 xl12 l12 center-align">
                            S/
                            <div class="input-field inline ">
                                <input id="saldoActual" type="hidden" value="<?php echo $cliente['saldoBilletera'] ?>">
                                <input name="idCliente" type="hidden" value="<?php echo $idCliente ?>">
                                <input placeholder="1.0" step="0.01" min="0" name="montoConsumo"
                                       value="<?php echo $costoDelivery; ?>"
                                       onkeypress="return consumoInput()" required
                                       id="consumoAreducir" type="number" class="validate center-align">

                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col l12 s12 xl12 m12 center-align">
                            <p id="msgSaldoInsuficiente" class="red-text" style="display: block"><strong>No tiene saldo
                                    suficiente</strong></p>

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


</div>
<?php include 'layout/userFooter.php' ?>
<script>
    $(document).ready(function () {
        $('#msgSaldoInsuficiente').hide();
    });

    function consumoInput(e) {
        let keynum = window.event ? window.event.keyCode : e.which;
        if ((keynum == 8) || (keynum == 46)) {
            return true;
        }
        return /\d/.test(String.fromCharCode(keynum));
    }

    $('#consumoCliente').submit(function () {
        let saldoActual = $('#saldoActual').val();
        let consumoAreducir = $('#consumoAreducir').val();



        return true;

    });
    <?php
    if (isset($_SESSION['mensaje'])) {
    if ($_SESSION['mensaje'] == 'correcto') {
    ?>
    M.toast({html: 'Se a agregado el consumo correctamente!'});

    <?php
    unset($_SESSION['mensaje']);
    }

    if ($_SESSION['mensaje'] == 'error') {
    ?>
    M.toast({html: 'ERROR, INGRESE UN NUMERO CORRECTO!'});

    <?php
    unset($_SESSION['mensaje']);
    }


    }
    ?>
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
