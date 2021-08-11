<?php
session_start();
$page = 'calidad';
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
include 'model/FeedBack.php';
$objFeedBack = new FeedBack();


date_default_timezone_set('America/Lima');
$actualDate = date('Ymd');

if (isset($_GET['date'])) {
    $selectedDate = $_GET['date'];
    $feedBacks = $objFeedBack->getFeedBacksByDate($selectedDate);

} elseif (isset($_GET['code'])) {
    $code = $_GET['code'];
    if ($code == 'limit50') {
        $feedBacks = $objFeedBack->getFeedBackLimit50();
    }

} else {
    $feedBacks = $objFeedBack->getFeedBacksByDate($actualDate);
}


include 'model/Tienda.php';


?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>.::Dashboard::.</title>
    <?php include 'layout/library.php' ?>

    <script src="js/dashboardHead.js"></script>


    <style>
        .switch label {
            font-weight: 900;
        }
    </style>




    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.21/css/jquery.dataTables.min.css"/>
    <link rel="stylesheet" type="text/css"



          href="https://cdn.datatables.net/responsive/2.2.4/css/responsive.dataTables.min.css"/>
    <link rel="stylesheet" type="text/css"
          href="https://cdn.datatables.net/buttons/1.6.2/css/buttons.dataTables.min.css"/>




   <script type="text/javascript" src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
    <script type="text/javascript"
            src="https://cdn.datatables.net/responsive/2.2.4/js/dataTables.responsive.min.js"></script>
    <script type="text/javascript"
            src="https://cdn.datatables.net/buttons/1.6.2/js/dataTables.buttons.min.js"></script>



</head>
<body class="">
<?php include 'layout/userNavBar.php' ?>
<div class="container">
    <div class="row" style="padding: 0 20px 20px 20px !important;margin-top: 30px">
        <div class="col l4 push-l4 pull-l4 s12 center-align z-depth-4"
             style="border-radius:5px;border: 2px solid black">
            <?php
            if (isset($_GET['date'])) {
                $selectedDate = $_GET['date'];
                echo '<h6 style="font-weight: 900"><u>' . $selectedDate . '</u></h6>';
            } elseif (isset($_GET['code'])) {

                echo '<h6 style="font-weight: 900"><u>Ultimos 50 pedidos</u></h6>';

            } else {
                ?>
                <h6 id="" style="font-weight: 900"><u id="fechaActual"></u></h6>
                <script>dia()</script>
                <?php
            }
            ?>

            <label><strong>FILTRAR</strong></label>
            <select class="browser-default" onchange="filtrar(this.value)">
                <option value="" disabled selected>Elige un Opción</option>
                <option value="1">POR FECHA</option>
                <option value="2">ULTIMOS 50 PEDIDOS</option>
                <option value="3">HOY</option>

            </select>
            <input type="text" id="fecha" class="datepicker">

        </div>
    </div>
    <div class="row">
        <div class="col s12">
            <table id="feedBackTable" class="nowrap" style="width: 100%">
                <thead>
                <tr>

                    <th>Nombre</th>
                    <th>Correo</th>
                    <th>Como calificas el tiempo de espera de tu pedido?</th>
                    <th>Como calificas las medidas de higiene que tuvo el motorizado al entregar el pedido?</th>
                    <th>El motorizado mantuvo el metro de distancia mínima al entregar el pedido?</th>
                    <th>Como calificas la presentación del empaque de tu pedido?</th>
                    <th>El empaque tuvo los precintos completamente intactos al momento de la entrega?</th>
                    <th>Recibió lo que ordenó sin variaciones?</th>
                    <th>Como califica el punto de cocción y sabor de los alimentos contenidos en su pedido?</th>
                    <th>El producto que recibiste cumplió con la calidad descrita en la carta?</th>
                    <th>Recomendaría nuestro restaurante a sus amigos o familiares?</th>
                    <th>Te encuentras satisfecho con nuestro servicio delivery?</th>
                    <th>Volverías a realizar pedidos por nuestra web?</th>
                    <th>Comentario</th>
                </tr>
                </thead>

                <tbody>
                <?php foreach ($feedBacks as $feedBack) { ?>
                    <tr>
                        <td><?php echo $feedBack['nombre'] ?></td>
                        <td><?php echo $feedBack['email'] ?></td>

                        <?php $decoded = base64_decode($feedBack['reaction']);
                        $arrayDecoded = json_decode($decoded,true);


                        ?>
                        <?php foreach ($arrayDecoded as $pregunta) { ?>
                            <td><?php echo $pregunta['respuesta'] ?></td>
                        <?php } ?>
                        <td><?php echo $feedBack['message'] ?></td>

                    </tr>
                <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?php include 'layout/userFooter.php' ?>


<script>
    function filtrar(value) {
        if (value == 1) {
            $('.datepicker').datepicker('open');
        }
        if (value == 2) {
            window.location = `calidad?code=limit50`
        }
        if (value == 3) {
            window.location = `calidad`

        }


    }

    let hoy = new Date();
    let dd = hoy.getDate();

    $(document).ready(function () {
        $('.datepicker').hide();

        $('.datepicker').datepicker({
            formatSubmit: 'yyyymmdd',
            onSelect: function (date) {

                var mes = date.getMonth() + 1; //obteniendo mes
                var dia = date.getDate(); //obteniendo dia
                var ano = date.getFullYear(); //obteniendo año
                if (dia < 10)
                    dia = '0' + dia; //agrega cero si el menor de 10
                if (mes < 10)
                    mes = '0' + mes //agrega cero si el menor de 10

                var fechaActual = ano + "-" + mes + "-" + dia;

                console.log(fechaActual);
                window.location = `calidad?date=${fechaActual}`

            },
            format: 'yyyymmdd',
            i18n: {
                months: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
                monthsShort: ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic'],
                weekdays: ['Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado'],
                weekdaysShort: ['Dom', 'Lun', 'Mar', 'Mié', 'Jue', 'Vie', 'Sáb'],
                weekdaysAbbrev: ['D', 'L', 'M', 'M', 'J', 'V', 'S'],
                clear: 'Limpiar',
                done: 'Ok',
                cancel: 'Cancelar'
            },
            max: true
        });

    });

    $(document).ready(function () {


        $('#feedBackTable').DataTable({
            "language": {
                "url": "https://cdn.datatables.net/plug-ins/1.10.20/i18n/Spanish.json"
            },
            responsive: true,
            "pageLength": 50,
            dom: 'Bfrtip',
            buttons: [
                'copy', 'excel', 'pdf'
            ]
        });


    });

</script>

</body>
</html>
