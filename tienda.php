<?php
session_start();
$page = 'store';
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

include 'model/Tienda.php';

include 'model/Delivery.php';


$objTienda = new Tienda();
$objDelivery = new Delivery();
$tienda = $objTienda->getStoreStatus();


$estado = $tienda['estado'];
$costoDelivery = trim($objTienda->getCostoEnvio()['costoDelivery']);



$listaDistritosConCosto = $objDelivery->getCostoPorDistritos();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>.::Dashboard::.</title>
    <?php include 'layout/library.php' ?>

    <script
            src="https://maps.googleapis.com/maps/api/js?key=AIzaSyArTyoCYqHm0479cO0A1WNMv3w1X0uLjQo&libraries=places"
    ></script>
    <style>
        .switch label {
            font-weight: 900;
        }

        .width-100 {
            width: 100%;
        }

        .d-node {
            display: none;
        }
    </style>
</head>
<body class="">
<?php include 'layout/userNavBar.php' ?>
<div class="container">
    <div class="row">
        <div class="col l6 s12 m6 xl6   "
             style="">
            <div class="z-depth-5" style="border-radius: 5px; border: 3px solid black;margin-top: 30px;">
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

           <!-- <div class="z-depth-5" style="border-radius: 5px; border: 3px solid black;margin-top: 30px;">
                <h5 class="center-align">Disponibilidad de las tiendas</h5>

                <?php foreach ($objTienda->getEstadoTiendas() as $item) { ?>


                    <div class="switch center-align " style="margin-top: 100px;margin-bottom: 100px">
                        <?php if ($item['idTienda'] === '1') {
                            ?>
                            <h5>Tienda Lince</h5>
                        <?php } ?>
                        <?php if ($item['idTienda'] === '2') {
                            ?>
                            <h5>Tienda Surco</h5>
                        <?php } ?>
                        <label>
                            CERRADO
                            <input <?= ($item['acepta_pedidos'] == 'TRUE') ? 'checked' : '' ?>
                                    onclick="actualizarDisponibilidad('<?= $item['acepta_pedidos'] ?>','<?= $item['idTienda'] ?>')"
                                    id="chkTiendaStatus" type="checkbox" class="">
                            <span class="lever"></span>
                            ABIERTO
                        </label>
                    </div>
                <?php } ?>


            </div> -->

        </div>

        <div class="col l6 s12 m6 xl6   "
             style="">
            <div class="z-depth-5" style="border-radius: 5px; border: 3px solid black;margin-top: 30px;padding:15px">
                <h5 class="center-align">Costos de Delivery</h5>

                <?php foreach ($listaDistritosConCosto as $item) { ?>
                    <form onsubmit="actualizarCostoDeEnvio(event)">
                        <input type="hidden" class="idDelivery" value="<?= $item['id'] ?>">
                        <div class="d-node coords"><?= $item['coords'] ?></div>
                        <div class="row">
                            <div class="col s6">
                                <h6><?= ($item['idTienda'] == '1') ?  $item['name'] :  $item['name'] ?></h6>
                            </div>
                            <div class="col s6">
                                <div class="input-field col s12 ">
                                    <input type="text" class="validate browser-default precioDistrito width-100"
                                           value="<?= $item['price'] ?>">

                                </div>

                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12 center-align">
                                <a onclick="previewMapsModal(this)"
                                   class="btn btn-flat btn-small grey waves-effect waves-green white-text ">
                                    <i class="material-icons">
                                        remove_red_eye
                                    </i>
                                </a>

                                <button type="submit"
                                        class="btn btn-flat btn-small teal waves-effect waves-green white-text ">
                                    Guardar
                                    <i class="material-icons right">
                                        save
                                    </i>
                                </button>
                                <br>
                                <hr>

                            </div>
                        </div>
                    </form>

                <?php } ?>
            </div>

        </div>

    </div>


   
</div>
<!-- Modal Structure -->
<div id="modalPreviewMaps" class="modal">
    <div class="modal-content">
        <h4>Zona de reparto</h4>
        <div id="mapContainer" style="height: 400px;width: 100%">

        </div>
    </div>
    <div class="modal-footer">
        <a id="previewMapClose" href="#!" class="modal-close waves-effect waves-green btn-flat red white-text">Cerrar</a>
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
    }

/*
    $(".chkStock").on("click", function (e) {
        var checkbox = $(this);
        var url = "ajax/changeStockStatusIngrediente.php";
        var id = $(this).attr("data-idProducto");


        if (checkbox.is(":checked")) {

            var stock = "ACTIVO";
            var datos = {id: id, stock: stock};
            $.post(url, datos, function (data) {
                console.log(data);
            }).fail(function () {
                alert("Se produjo un error, Verifica tu conexión a internet");
                location.reload();
            });
        } else {
            var stock = "INACTIVO";
            var datos = {id: id, stock: stock};
            $.post(url, datos, function (data) {
                console.log(data);
            }).fail(function () {
                alert("Se produjo un error, Verifica tu conexión a internet");
                location.reload();
            });
        }
    });
*/
    function actualizarCostoDeEnvio($event) {
        $event.preventDefault();
        let idDelivery = $event.target.querySelector(".idDelivery").value;
        let precioDelivery = $event.target.querySelector(".precioDistrito").value;
        const data = new FormData();
        data.append('idDelivery', idDelivery);
        data.append('precioDelivery', precioDelivery);
        fetch('script/delivery/cambiarPrecioDelivery', {method: 'POST', body: data}).then(value => {
            if (value.ok) {
                return value.text();
            }
        }).then(value => {
            console.log(value);
            window.location.reload();
        })

    }

    function actualizarDisponibilidad(status, id) {
        console.log(status);
        console.log(id);
        let data = new FormData();

        if (status === 'TRUE') {
            data.append('status', 'FALSE')
        }
        if (status === 'FALSE') {
            data.append('status', 'TRUE')
        }
        data.append('id', id);

        fetch('utils/cambiarDisponibilidad.php', {body: data, method: 'POST'}).then(value => {
            if (value.ok) {
                return value.text();
            }
        }).then(value => {
            window.location.reload();
        })

    }

</script>


<?php
if (isset($_GET['code'])) {
    if ($_GET['code'] == 'success') { ?>
        <script>M.toast({html: 'Correcto! Se ha Actualizado la Tienda!'})</script>
        <?php
    }
}
?>
<script>

    const mapContainer = document.getElementById('mapContainer');
    const previewMapClose = document.getElementById('previewMapClose');
    let map;

    previewMapClose.addEventListener('click', function () {
        map = null;

    })

    function previewMapsModal(element) {
        const coords = JSON.parse(element.parentElement.parentElement.parentElement.querySelector('.coords').innerText);
        $('#modalPreviewMaps').modal({
            dismissible: false
        });
        $('#modalPreviewMaps').modal('open');

        initMap();
        const bermudaTriangle = new google.maps.Polygon({
            paths: coords,
            strokeColor: "#FF0000",
            strokeOpacity: 0.8,
            strokeWeight: 2,
            fillColor: "#FF0000",
            fillOpacity: 0.35,
        });
        bermudaTriangle.setMap(map);

    }

    function initMap() {
        let mapsOptions = {
            zoom: 12,
            streetViewControl: false,
            center: new google.maps.LatLng(-12.1102611, -76.9786420),
            mapTypeControl: false
        };
        map = new google.maps.Map(mapContainer, mapsOptions
        );
    }
</script>
</body>
</html>
