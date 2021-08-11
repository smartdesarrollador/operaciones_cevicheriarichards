<?php
session_start();
$page = 'usuarios';
error_reporting(0);
if (isset($_SESSION["current_email"]) && $_SESSION["current_email"] != '') {

} else {
    echo "Usuario no Autorizado";
    exit();
}

if ($_SESSION['current_rol'] == 'admin') {

} else {
    echo "No tienes Permisos para acceder a este lugar";
    exit();
}

include 'model/Clientes.php';

$objTienda = new Clientes();

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>.::Usuarios::.</title>
    <?php include 'layout/library.php' ?>


    <style>
        .switch label {
            font-weight: 900;
        }
    </style>
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/dt/dt-1.10.20/datatables.min.css"/>

    <script type="text/javascript" src="https://cdn.datatables.net/v/dt/dt-1.10.20/datatables.min.js"></script>
</head>
<body class="">
<?php include 'layout/userNavBar.php' ?>
<div class="container">
    <div class="row">
        <div class="col l4 s12 m4 xl4 push-l4 push-l4 push-xl4  push-m4 pull-m4 z-depth-5 hoverable "
             style="border-radius: 5px; border: 3px solid black;margin-top: 30px">
            <h5 class="center-align">Listado de Usuarios</h5>

        </div>
    </div>

    <div class="row">

        <div class="row">
            <div class="col s12 center-align">
                <ul class="tabs tabs-fixed-width">
                    <li class="tab col s3"><a class="active " href="#test1">PUNTOS</a></li>
                    <li class="tab col s3"><a href="#test2">VENTAS</a></li>

                </ul>
            </div>

        </div>


        <div id="test1" class="col s12  z-depth-5 hoverable "
             style="border-radius: 5px; border: 3px solid black;margin-top: 30px">
            <table id="puntos" class="display " style="width:100%">
                <thead>
                <tr>
                    <th>Nombre</th>
                    <th>Correo</th>
                    <th>Puntos</th>


                </tr>
                </thead>
                <tbody>
                <?php foreach ($objTienda->getPuntosClientes() as $puntos) { ?>
                    <tr>
                        <td><?php echo $puntos['nombre'].' '.$puntos['apellido'] ?></td>
                        <td><?php echo $puntos['email'] ?></td>
                        <td><?php echo $puntos['puntos'] ?></td>
                    </tr>
                <?php } ?>
                </tbody>
            </table>

        </div>

        <div id="test2" class="col s12  z-depth-5 hoverable "
             style="border-radius: 5px; border: 3px solid black;margin-top: 30px">
            <table id="ventas" class="display " style="width:100%">
                <thead>
                <tr>
                    <th>Nombre</th>
                    <th>Correo</th>
                    <th>Compras</th>


                </tr>
                </thead>
                <tbody>
                <?php foreach ($objTienda->getComprasxCliente() as $compras) { ?>
                    <tr>
                        <td><?php echo $compras['nombre'] .' '. $compras['apellido'] ?></td>
                        <td><?php echo $compras['email'] ?></td>
                        <td>$<?php echo $compras['total'] ?></td>
                    </tr>
                <?php } ?>
                </tbody>
            </table>

        </div>
    </div>


</div>
<?php include 'layout/userFooter.php' ?>
<script>



    $(document).ready(function () {

        $('#puntos').DataTable({
            "language": {
                "url": "https://cdn.datatables.net/plug-ins/1.10.20/i18n/Spanish.json"
            },
            responsive: true
        });
        $('#ventas').DataTable({
            "language": {
                "url": "https://cdn.datatables.net/plug-ins/1.10.20/i18n/Spanish.json"
            },
            responsive: true
        });


    });

    $(document).ready(function () {
        $('.tabs').tabs();
    });
</script>
</body>
</html>
